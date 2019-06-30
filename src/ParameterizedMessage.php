<?php

declare(strict_types=1);

namespace Solodkiy\MysqlErrorsParser;

final class ParameterizedMessage
{
    /**
     * @var string
     */
    private $template;

    /**
     * @var array
     */
    private $params;

    /**
     * ParameterizedMessage constructor.
     * @param string $template
     * @param array $params
     */
    public function __construct(string $template, array $params)
    {
        $this->template = $template;
        $this->params = $params;
    }

    /**
     * @return string
     */
    public function getTemplate(): string
    {
        return $this->template;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }
}
