<?php

declare(strict_types=1);

namespace Solodkiy\MysqlErrorsParser\Generator;

use Aza\Components\PhpGen\PhpGen;
use DOMDocument;
use DOMElement;
use DOMXPath;
use RuntimeException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ExtractListCommand extends Command
{
    /**
     * TestCommand constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('extract-list')
            ->addArgument('file', InputArgument::REQUIRED)
            ->addArgument('compare', InputArgument::OPTIONAL)
            ->addOption('client', 'c', InputOption::VALUE_NONE);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $filePath = $input->getArgument('file');
        if (!is_file($filePath)) {
            throw new RuntimeException('Source file ' . $filePath . ' not found');
        }
        $comparePath = $input->getArgument('compare');
        if ($comparePath && !is_file($comparePath)) {
            throw new RuntimeException('Compare file ' . $comparePath. ' not found');
        }

        $content = file_get_contents($filePath);
        $dom = new DOMDocument();
        $dom->loadHTML($content);
        $xpath = new DOMXpath($dom);
        $nodes = $xpath->query('/html/body/div/ul/li');
        $i = 0;
        $errors = [];

        if ($comparePath) {
            /** @noinspection PhpIncludeInspection */
            $compare = require $comparePath;
        } else {
            $compare = [];
        }

        foreach ($nodes as $liNode) {
            $error = $this->extractError($liNode, $i, $input->getOption('client'));
            if (!$error) {
                continue;
            }

            $cleanTemplate = $this->cleanTemplate($error['template']);
            foreach ($compare as $compareItem) {
                if ($this->cleanTemplate($compareItem['template']) === $cleanTemplate) {
                    continue 2;
                }
            }

            $errors[] = $error;
            $i++;
        }

        $this->generateFile($errors);
    }

    private function cleanTemplate(string $template)
    {
        return preg_replace('~\{.+\}~', '%s', $template);
    }

    private function generateFile(array $errors)
    {
        $phpGen = new PhpGen();
        echo '<?php ' . "\n\n" . 'return ' . $phpGen->getCode($errors) . "\n";
    }

    private function extractError(DOMElement $liNode, int $nodeNumber, bool $clientError) : ?array
    {
        $codes = iterator_to_array($liNode->getElementsByTagName('code'));
        $codes = array_map(function (DOMElement $element): string {
            return $element->nodeValue;
        }, $codes);

        if ($clientError) {
            if (count($codes) < 2) {
                throw new RuntimeException('Failed to parse node #' . $nodeNumber);
            }
            [$errorNumber, $symbol] = $codes;
            $sqlState = null;
        } else {
            if (count($codes) < 3) {
                throw new RuntimeException('Failed to parse node #' . $nodeNumber);
            }
            [$errorNumber, $symbol, $sqlState] = $codes;
        }

        $ps = iterator_to_array($liNode->getElementsByTagName('p'));
        $messageBlock = $ps[1] ?? new DOMElement('empty', '', '');
        $template = $this->extractMessageFromBlock($messageBlock);
        if (is_null($template)) {
            throw new RuntimeException('Failed to extract message template. Node #' . $nodeNumber);
        }
        if (!$template) {
            return null;
        }

        if (!is_numeric($errorNumber)) {
            return null;
        }

        $result = [
            'code' => intval($errorNumber),
            'symbol' => $symbol,
            'sql_state' => $sqlState,
            'template' => $this->convertPercentTemplateToBracketTemplate($template),
        ];
        if (is_null($sqlState)) {
            unset($result['sql_state']);
        }

        return $result;
    }

    private function convertPercentTemplateToBracketTemplate(string $percentTemplate)
    {
        $paramNumber = 1;
        return preg_replace_callback(
            '/%([sdufc]|ll?u|ll?d|-?\.\*s)/', // ["%s", "%d", "%lu", "%ld", "lld", "%u", "%llu", "%-.*s", "%.*s", "%f"]
            function (array $match) use (&$paramNumber) {
                $pattern = $match[1];
                $result = in_array($pattern, ['s', '-.*s', '.*s'], true) ? '{#p' . $paramNumber . '}' : '{p' . $paramNumber . '}';
                $paramNumber++;
                return $result;
            },
            $percentTemplate
        );
    }

    private function extractMessageFromBlock(DOMElement $messageBlock): ?string
    {
        $nodeValue = trim($messageBlock->nodeValue);
        if (strpos($nodeValue, 'Message: ') === 0) {
            $message = substr($nodeValue, 9);
            return preg_replace('~\n\s+~', ' ', $message);
        }

        if ($nodeValue === 'Message:') {
            return '';
        }

        return null;
    }
}
