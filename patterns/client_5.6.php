<?php

$previous = require __DIR__ . '/client_5.5.php';

$new = [
    [
        "code"     => 2060,
        "symbol"   => "CR_DUPLICATE_CONNECTION_ATTR",
        "template" => "There is an attribute with the same name already",
    ],
    [
        "code"     => 2061,
        "symbol"   => "CR_AUTH_PLUGIN_ERR",
        "template" => "Authentication plugin '{#p1}' reported error: {#p2}",
    ],
];

return array_merge($previous, $new);
