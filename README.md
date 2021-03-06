# `gh640/sjis-stream-filter`

Provides 2 simple PHP stream filters for Shift-JIS encoding.

There're 2 filters available in this package.

- `gh640\SjisStreamFilter\Filter\SjisToUtf8Filter`
- `gh640\SjisStreamFilter\Filter\Utf8ToSjisFilter`

## Installation

You can install this package with `composer` command.

```bash
$ composer require gh640/sjis-stream-filter:1.0.0-alpha2
```

## Usage

The following stream filter classes can be used directly with `stream_filter_register()`.

- `gh640\SjisStreamFilter\Filter\SjisToUtf8Filter`
- `gh640\SjisStreamFilter\Filter\Utf8ToSjisFilter`

```php
<?php

// Register the sjis-to-utf8 filter.
$filtername = 'sjis_to_utf8_filter';
stream_filter_register($filtername, '\gh640\SjisStreamFilter\Filter\SjisToUtf8Filter');

// Use the filter when reading a sjis-encoded file.
$fp = fopen('a-file-encoded-with-sjis.txt', 'r');
stream_filter_append($fp, $filtername);
while (!feof($fp)) {
  $line = fgets($fp);
  print $line;
}
fclose($fp);

?>
```

Also, there's a manager class `SjisFilterManager` which allow to use the filters easily.

```php
<?php

use gh640\SjisStreamFilter\Manager\SjisFilterManager;

// Register the sjis-to-utf8 filter.
$filter_manager = new SjisFilterManager();

$filtername = $filter_manager->register(SjisFilterManager::FILTER_SJIS_TO_UTF8);

// Read a file encoded with sjis.
$fp = fopen('a-file-encoded-with-sjis.txt', 'r');
stream_filter_append($fp, $filtername);
while (!feof($fp)) {
  $line = fgets($fp);
  print $line;
}
fclose($fp);

// Register the utf8-to-sjis filter.
$filtername = $filter_manager->register(SjisFilterManager::FILTER_UTF8_TO_SJIS);

// Write a file with sjis encoding using php://filter.
$content = file_get_contents('utf8.txt');
file_put_contents("php://filter/${filtername}/resource=sjis.txt", $content);

?>
```

You can change the filter name by passing the second argument to `SjisFilterManager::register()`.

```php
<?php

public function register($type, $filtername = NULL);

?>
```

## License

Licensed under the MIT license.
