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
            ->addOption('client', 'c', InputOption::VALUE_NONE);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $filePath = $input->getArgument('file');
        if (!is_file($filePath)) {
            throw new RuntimeException('Source file ' . $filePath . ' not found');
        }
        $content = file_get_contents($filePath);
        $dom = new DOMDocument();
        $dom->loadHTML($content);
        $xpath = new DOMXpath($dom);
        $nodes = $xpath->query('/html/body/div/ul/li');
        $i = 0;
        $errors = [];

        $compare = require __DIR__ . '/../../patterns/server_5.7.php';

        foreach ($nodes as $liNode) {
            $error = $this->extractError($liNode, $i, $input->getOption('client'));

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

    private function extractError(DOMElement $liNode, int $nodeNumber, bool $clientError)
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
        if (!$template) {
            throw new RuntimeException('Failed to extract message template. Node #' . $nodeNumber);
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
            '/%([sdu]|lu|ld|llu)/', // ["%s", "%d", "%lu", "%ld", "%u", "%llu"]
            function (array $match) use (&$paramNumber) {
                $pattern = $match[1];
                $result = $pattern === 's' ? '{#p' . $paramNumber . '}' : '{p' . $paramNumber . '}';
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

        return null;
    }
}
