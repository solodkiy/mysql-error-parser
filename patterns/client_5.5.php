<?php

return [
    [
        "code"     => 2000,
        "symbol"   => "CR_UNKNOWN_ERROR",
        "template" => "Unknown MySQL error",
    ],
    [
        "code"     => 2001,
        "symbol"   => "CR_SOCKET_CREATE_ERROR",
        "template" => "Can't create UNIX socket ({p1})",
    ],
    [
        "code"     => 2002,
        "symbol"   => "CR_CONNECTION_ERROR",
        "template" => "Can't connect to local MySQL server through socket '{#p1}' ({p2})",
    ],
    [
        "code"     => 2003,
        "symbol"   => "CR_CONN_HOST_ERROR",
        "template" => "Can't connect to MySQL server on '{#p1}' ({p2})",
    ],
    [
        "code"     => 2004,
        "symbol"   => "CR_IPSOCK_ERROR",
        "template" => "Can't create TCP/IP socket ({p1})",
    ],
    [
        "code"     => 2005,
        "symbol"   => "CR_UNKNOWN_HOST",
        "template" => "Unknown MySQL server host '{#p1}' ({p2})",
    ],
    [
        "code"     => 2006,
        "symbol"   => "CR_SERVER_GONE_ERROR",
        "template" => "MySQL server has gone away",
    ],
    [
        "code"     => 2007,
        "symbol"   => "CR_VERSION_ERROR",
        "template" => "Protocol mismatch; server version = {p1}, client version = {p2}",
    ],
    [
        "code"     => 2008,
        "symbol"   => "CR_OUT_OF_MEMORY",
        "template" => "MySQL client ran out of memory",
    ],
    [
        "code"     => 2009,
        "symbol"   => "CR_WRONG_HOST_INFO",
        "template" => "Wrong host info",
    ],
    [
        "code"     => 2010,
        "symbol"   => "CR_LOCALHOST_CONNECTION",
        "template" => "Localhost via UNIX socket",
    ],
    [
        "code"     => 2011,
        "symbol"   => "CR_TCP_CONNECTION",
        "template" => "{#p1} via TCP/IP",
    ],
    [
        "code"     => 2012,
        "symbol"   => "CR_SERVER_HANDSHAKE_ERR",
        "template" => "Error in server handshake",
    ],
    [
        "code"     => 2013,
        "symbol"   => "CR_SERVER_LOST",
        "template" => "Lost connection to MySQL server during query",
    ],
    [
        "code"     => 2014,
        "symbol"   => "CR_COMMANDS_OUT_OF_SYNC",
        "template" => "Commands out of sync; you can't run this command now",
    ],
    [
        "code"     => 2015,
        "symbol"   => "CR_NAMEDPIPE_CONNECTION",
        "template" => "Named pipe: {#p1}",
    ],
    [
        "code"     => 2016,
        "symbol"   => "CR_NAMEDPIPEWAIT_ERROR",
        "template" => "Can't wait for named pipe to host: {#p1} pipe: {#p2} ({p3})",
    ],
    [
        "code"     => 2017,
        "symbol"   => "CR_NAMEDPIPEOPEN_ERROR",
        "template" => "Can't open named pipe to host: {#p1} pipe: {#p2} ({p3})",
    ],
    [
        "code"     => 2018,
        "symbol"   => "CR_NAMEDPIPESETSTATE_ERROR",
        "template" => "Can't set state of named pipe to host: {#p1} pipe: {#p2} ({p3})",
    ],
    [
        "code"     => 2019,
        "symbol"   => "CR_CANT_READ_CHARSET",
        "template" => "Can't initialize character set {#p1} (path: {#p2})",
    ],
    [
        "code"     => 2020,
        "symbol"   => "CR_NET_PACKET_TOO_LARGE",
        "template" => "Got packet bigger than 'max_allowed_packet' bytes",
    ],
    [
        "code"     => 2021,
        "symbol"   => "CR_EMBEDDED_CONNECTION",
        "template" => "Embedded server",
    ],
    [
        "code"     => 2022,
        "symbol"   => "CR_PROBE_SLAVE_STATUS",
        "template" => "Error on SHOW SLAVE STATUS:",
    ],
    [
        "code"     => 2023,
        "symbol"   => "CR_PROBE_SLAVE_HOSTS",
        "template" => "Error on SHOW SLAVE HOSTS:",
    ],
    [
        "code"     => 2024,
        "symbol"   => "CR_PROBE_SLAVE_CONNECT",
        "template" => "Error connecting to slave:",
    ],
    [
        "code"     => 2025,
        "symbol"   => "CR_PROBE_MASTER_CONNECT",
        "template" => "Error connecting to master:",
    ],
    [
        "code"     => 2026,
        "symbol"   => "CR_SSL_CONNECTION_ERROR",
        "template" => "SSL connection error: {#p1}",
    ],
    [
        "code"     => 2027,
        "symbol"   => "CR_MALFORMED_PACKET",
        "template" => "Malformed packet",
    ],
    [
        "code"     => 2028,
        "symbol"   => "CR_WRONG_LICENSE",
        "template" => "This client library is licensed only for use with MySQL servers having '{#p1}' license",
    ],
    [
        "code"     => 2029,
        "symbol"   => "CR_NULL_POINTER",
        "template" => "Invalid use of null pointer",
    ],
    [
        "code"     => 2030,
        "symbol"   => "CR_NO_PREPARE_STMT",
        "template" => "Statement not prepared",
    ],
    [
        "code"     => 2031,
        "symbol"   => "CR_PARAMS_NOT_BOUND",
        "template" => "No data supplied for parameters in prepared statement",
    ],
    [
        "code"     => 2032,
        "symbol"   => "CR_DATA_TRUNCATED",
        "template" => "Data truncated",
    ],
    [
        "code"     => 2033,
        "symbol"   => "CR_NO_PARAMETERS_EXISTS",
        "template" => "No parameters exist in the statement",
    ],
    [
        "code"     => 2034,
        "symbol"   => "CR_INVALID_PARAMETER_NO",
        "template" => "Invalid parameter number",
    ],
    [
        "code"     => 2035,
        "symbol"   => "CR_INVALID_BUFFER_USE",
        "template" => "Can't send long data for non-string/non-binary data types (parameter: {p1})",
    ],
    [
        "code"     => 2036,
        "symbol"   => "CR_UNSUPPORTED_PARAM_TYPE",
        "template" => "Using unsupported buffer type: {p1} (parameter: {p2})",
    ],
    [
        "code"     => 2037,
        "symbol"   => "CR_SHARED_MEMORY_CONNECTION",
        "template" => "Shared memory: {#p1}",
    ],
    [
        "code"     => 2038,
        "symbol"   => "CR_SHARED_MEMORY_CONNECT_REQUEST_ERROR",
        "template" => "Can't open shared memory; client could not create request event ({p1})",
    ],
    [
        "code"     => 2039,
        "symbol"   => "CR_SHARED_MEMORY_CONNECT_ANSWER_ERROR",
        "template" => "Can't open shared memory; no answer event received from server ({p1})",
    ],
    [
        "code"     => 2040,
        "symbol"   => "CR_SHARED_MEMORY_CONNECT_FILE_MAP_ERROR",
        "template" => "Can't open shared memory; server could not allocate file mapping ({p1})",
    ],
    [
        "code"     => 2041,
        "symbol"   => "CR_SHARED_MEMORY_CONNECT_MAP_ERROR",
        "template" => "Can't open shared memory; server could not get pointer to file mapping ({p1})",
    ],
    [
        "code"     => 2042,
        "symbol"   => "CR_SHARED_MEMORY_FILE_MAP_ERROR",
        "template" => "Can't open shared memory; client could not allocate file mapping ({p1})",
    ],
    [
        "code"     => 2043,
        "symbol"   => "CR_SHARED_MEMORY_MAP_ERROR",
        "template" => "Can't open shared memory; client could not get pointer to file mapping ({p1})",
    ],
    [
        "code"     => 2044,
        "symbol"   => "CR_SHARED_MEMORY_EVENT_ERROR",
        "template" => "Can't open shared memory; client could not create {#p1} event ({p2})",
    ],
    [
        "code"     => 2045,
        "symbol"   => "CR_SHARED_MEMORY_CONNECT_ABANDONED_ERROR",
        "template" => "Can't open shared memory; no answer from server ({p1})",
    ],
    [
        "code"     => 2046,
        "symbol"   => "CR_SHARED_MEMORY_CONNECT_SET_ERROR",
        "template" => "Can't open shared memory; cannot send request event to server ({p1})",
    ],
    [
        "code"     => 2047,
        "symbol"   => "CR_CONN_UNKNOW_PROTOCOL",
        "template" => "Wrong or unknown protocol",
    ],
    [
        "code"     => 2048,
        "symbol"   => "CR_INVALID_CONN_HANDLE",
        "template" => "Invalid connection handle",
    ],
    [
        "code"     => 2049,
        "symbol"   => "CR_SECURE_AUTH",
        "template" => "Connection using old (pre-4.1.1) authentication protocol refused (client option 'secure_auth' enabled)",
    ],
    [
        "code"     => 2050,
        "symbol"   => "CR_FETCH_CANCELED",
        "template" => "Row retrieval was canceled by mysql_stmt_close() call",
    ],
    [
        "code"     => 2051,
        "symbol"   => "CR_NO_DATA",
        "template" => "Attempt to read column without prior row fetch",
    ],
    [
        "code"     => 2052,
        "symbol"   => "CR_NO_STMT_METADATA",
        "template" => "Prepared statement contains no metadata",
    ],
    [
        "code"     => 2053,
        "symbol"   => "CR_NO_RESULT_SET",
        "template" => "Attempt to read a row while there is no result set associated with the statement",
    ],
    [
        "code"     => 2054,
        "symbol"   => "CR_NOT_IMPLEMENTED",
        "template" => "This feature is not implemented yet",
    ],
    [
        "code"     => 2055,
        "symbol"   => "CR_SERVER_LOST_EXTENDED",
        "template" => "Lost connection to MySQL server at '{#p1}', system error: {p2}",
    ],
    [
        "code"     => 2056,
        "symbol"   => "CR_STMT_CLOSED",
        "template" => "Statement closed indirectly because of a preceeding {#p1}() call",
    ],
    [
        "code"     => 2057,
        "symbol"   => "CR_NEW_STMT_METADATA",
        "template" => "The number of columns in the result set differs from the number of bound buffers. You must reset the statement, rebind the result set columns, and execute the statement again",
    ],
    [
        "code"     => 2058,
        "symbol"   => "CR_ALREADY_CONNECTED",
        "template" => "This handle is already connected. Use a separate handle for each connection.",
    ],
    [
        "code"     => 2059,
        "symbol"   => "CR_AUTH_PLUGIN_CANNOT_LOAD",
        "template" => "Authentication plugin '{#p1}' cannot be loaded: {#p2}",
    ],
];
