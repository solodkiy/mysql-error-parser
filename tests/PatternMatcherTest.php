<?php

declare(strict_types=1);

namespace Solodkiy\MysqlErrorsParser;

use PHPUnit\Framework\TestCase;

class PatternMatcherTest extends TestCase
{
    /**
     * @param int $code
     * @param string $message
     * @param $expectedResult
     * @dataProvider matchErrorProvider
     */
    public function testMatchError(int $code, string $message, $expectedResult)
    {
        $matcher = new PatternMatcher(true);
        $result = $matcher->matchError($code, $message);

        $this->assertEquals($expectedResult, $result);
    }

    public function matchErrorProvider()
    {
        return [
            'static_message' => [
                1213,
                'Deadlock found when trying to get lock; try restarting transaction',
                new ParameterizedMessage(
                    'Deadlock found when trying to get lock; try restarting transaction',
                    []
                ),
            ],
            '1062' => [
                1062,
                "Duplicate entry '13340' for key 'PRIMARY'",
                new ParameterizedMessage(
                    "Duplicate entry '{entry}' for key '{#key}'",
                    [
                        'entry' => '13340',
                        'key' => 'PRIMARY',
                    ]
                )
            ],
            '1264' => [
                1264,
                "Out of range value for column 'apple_review_id' at row 1",
                new ParameterizedMessage(
                    "Out of range value for column '{#column}' at row {row}",
                    [
                        'column' => 'apple_review_id',
                        'row' => '1',
                    ]
                )
            ],
            '1101_1' => [
                1101,
                "BLOB/TEXT column 'text' can't have a default value",
                new ParameterizedMessage(
                    "BLOB/TEXT column '{#p1}' can't have a default value",
                    [
                        'p1' => 'text'
                    ]
                )
            ],
            '1101_2' => [
                1101,
                "BLOB, TEXT, GEOMETRY or JSON column 'text' can't have a default value",
                new ParameterizedMessage(
                    "BLOB, TEXT, GEOMETRY or JSON column '{#p1}' can't have a default value",
                    [
                        'p1' => 'text'
                    ]
                )
            ],
            '1292' => [
                1292,
                "Truncated incorrect DOUBLE value: '22 AND bac.is_active=1'",
                new ParameterizedMessage(
                    "Truncated incorrect {#type} value: '{value}'",
                    [
                        'type' => 'DOUBLE',
                        'value' => '22 AND bac.is_active=1'
                    ]
                )
            ],
            '1265' => [
                1265,
                "Data truncated for column 'status' at row 1",
                new ParameterizedMessage(
                    "Data truncated for column '{#column}' at row {row}",
                    [
                        'column' => 'status',
                        'row' => '1',
                    ]
                )
            ],
            '1146' => [
                1146,
                "Table 'Spotlight.RemoveBets_201906' doesn't exist",
                new ParameterizedMessage(
                    "Table '{#db}.{#table}' doesn't exist",
                    [
                        'db' => 'Spotlight',
                        'table' => 'RemoveBets_201906',
                    ]
                )
            ],
            '2002' => [
                2002,
                "Can't connect to local MySQL server through socket '/var/lib/mysql/mysql.sock' (38)",
                new ParameterizedMessage(
                    "Can't connect to local MySQL server through socket '{#p1}' ({p2})",
                    [
                        'p1' => '/var/lib/mysql/mysql.sock',
                        'p2' => '38',
                    ]
                )
            ],
            '3170' => [
                3170,
                "Memory capacity of 8388608 bytes for 'range_optimizer_max_mem_size' exceeded. Range optimization was not done for this query.",
                new ParameterizedMessage(
                    "Memory capacity of {bytes} bytes for '{#param}' exceeded. {#message}",
                    [
                        'bytes' => '8388608',
                        'param' => 'range_optimizer_max_mem_size',
                        'message' => 'Range optimization was not done for this query.'
                    ]
                )
            ],
        ];
    }

    public function testMatchErrorWithoutSmartParams()
    {
        $matcher = new PatternMatcher(false);
        $result = $matcher->matchError(
            1146,
            "Table 'Spotlight.RemoveBets_201906' doesn't exist",
        );
        $expectedTemplate = "Table '{db}.{table}' doesn't exist";
        $this->assertSame($expectedTemplate, $result->getTemplate());
    }
}
