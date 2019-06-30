MySQL error parser
==================

This lib provides regex patterns for all mysql server errors from version 5.5 to 5.7.  
It can be used for extracting detailed information from your mysql errors and future analisys.

**Usage example**
```php
$connect = new \mysqli('localhost', 'root', '');
$result = $connect->query('select * from db.unknown_table');
if (!$result) {
    $parser = new \Solodkiy\MysqlErrorsParser\PatternMatcher();
    $structuredError = $parser->matchError($connect->errno, $connect->error);
    var_dump(
        $connect->error, 
        $structuredError->getTemplate(), 
        $structuredError->getParams()
    );
}
```

**Result**
```
string(38) "Table 'db.unknown_table' doesn't exist"
string(34) "Table '{db}.{table}' doesn't exist"
array(2) {
  'db' => string(2) "db"
  'table' => string(13) "unknown_table"
}
```

Install
-------
```
composer require solodkiy/mysql-error-parser
```
