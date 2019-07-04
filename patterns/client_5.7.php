<?php

$previous = require __DIR__ . '/client_5.5.php';

$new = [
    [
        "code"     => 2062,
        "symbol"   => "CR_INSECURE_API_ERR",
        "template" => "Insecure API function call: '{#p1}' Use instead: '{#p2}'",
    ],
    [
        "code"     => 2049,
        "symbol"   => "CR_UNUSED_1",
        "template" => "Connection using old (pre-4.1.1) authentication protocol refused (client option 'secure_auth' enabled)",
    ],
    [
        "code"     => 2056,
        "symbol"   => "CR_STMT_CLOSED",
        "template" => "Statement closed indirectly because of a preceding {#p1}() call",
    ]
];

return array_merge($previous, $new);
