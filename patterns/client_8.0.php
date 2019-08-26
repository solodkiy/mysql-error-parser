<?php

$previous = require __DIR__ . '/client_5.7.php';

$new = [
    [
        "code" => 2060,
        "symbol" => "CR_DUPLICATE_CONNECTION_ATTR",
        "template" => "There is an attribute with the same name already",
    ],
    [
        "code" => 2063,
        "symbol" => "CR_FILE_NAME_TOO_LONG",
        "template" => "File name is too long",
    ],
    [
        "code" => 2064,
        "symbol" => "CR_SSL_FIPS_MODE_ERR",
        "template" => "Set FIPS mode ON/STRICT failed",
    ],
    [
        "code" => 2065,
        "symbol" => "CR_COMPRESSION_NOT_SUPPORTED",
        "template" => "Compression protocol not supported with asynchronous protocol",
    ],
    [
        "code" => 2066,
        "symbol" => "CR_COMPRESSION_WRONGLY_CONFIGURED",
        "template" => "Connection failed due to wrongly configured compression algorithm",
    ],
];

return array_merge($previous, $new);
