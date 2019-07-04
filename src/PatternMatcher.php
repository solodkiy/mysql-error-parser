<?php

declare(strict_types=1);

namespace Solodkiy\MysqlErrorsParser;

final class PatternMatcher
{
    private const SERVER_PATTERNS_LIST_FILE = __DIR__ . '/../patterns/server_5.7.php';
    private const CLIENT_PATTERNS_LIST_FILE = __DIR__ . '/../patterns/client_5.7.php';

    private const PARAM_REGEX = '~\{#?([a-z0-9_-]+)\}~';

    /**
     * [code => patterns array]
     * @var array
     */
    private $map;

    /**
     * @var bool
     */
    private $useSmartParams;

    public function __construct(bool $useSmartParams = false)
    {
        $this->map = $this->indexList($this->loadData());
        $this->useSmartParams = $useSmartParams;
    }

    private function loadData(): array
    {
        /** @noinspection PhpIncludeInspection */
        $server = require self::SERVER_PATTERNS_LIST_FILE;
        /** @noinspection PhpIncludeInspection */
        $client = require self::CLIENT_PATTERNS_LIST_FILE;

        return array_merge($server, $client);
    }

    private function indexList(array $list)
    {
        $result = [];
        foreach ($list as $errorPattern) {
            $code = $errorPattern['code'];

            if (!array_key_exists($code, $result)) {
                $result[$code] = [];
            }
            $result[$code][] = $errorPattern;
        }
        return $result;
    }

    public function matchError(int $code, string $message): ?ParameterizedMessage
    {
        if (!array_key_exists($code, $this->map)) {
            return null;
        }
        foreach ($this->map[$code] as &$errorPattern) {
            if (!array_key_exists('regex', $errorPattern)) {
                $errorPattern['regex'] = $this->compileRegex($errorPattern['template']);
            }
            $regex = $errorPattern['regex'];

            $isMatched = preg_match($regex, $message, $m);
            if ($isMatched) {
                $params = $this->extractNamedParams($m);
                $template = $errorPattern['template'];
                if (!$this->useSmartParams) {
                    $template = $this->cleanStaticParamsFlag($template);
                }
                return new ParameterizedMessage($template, $params);
            }
        }
        return null;
    }

    private function extractNamedParams(array $matches): array
    {
        $params = [];
        foreach ($matches as $key => $value) {
            if (!is_int($key)) {
                $params[$key] = $value;
            }
        }
        return $params;
    }

    private function compileRegex(string $template): string
    {
        $parts = preg_split('~({#?[a-z0-9_-]+\})~', $template, -1, PREG_SPLIT_DELIM_CAPTURE);
        $result = [];
        foreach ($parts as $part) {
            if ($part && $part[0] === '{') {
                if (preg_match(self::PARAM_REGEX, $part, $m)) {
                    $paramName = $m[1];
                    if (is_numeric($paramName)) {
                        $paramName = 'p' . $paramName;
                    }
                    $result[] = '(?<' . $paramName . '>.*)';
                } else {
                    $result[] = preg_quote($part, '/');
                }
            } else {
                $result[] = preg_quote($part, '/');
            }
        }
        return '~^' . implode('', $result) . '$~';
    }

    private function cleanStaticParamsFlag(string $template): string
    {
        return str_replace('{#', '{', $template);
    }
}
