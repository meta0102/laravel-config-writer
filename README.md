## Laravel Config Writer

Write to Laravel Config files and maintain file integrity.

This library is an extension of the Config component used by Laravel. It adds the ability to write to configuration files.

You can rewrite array values inside a basic configuration file that returns a single array definition (like a Laravel config file) whilst maintaining the file integrity, leaving comments and advanced settings intact.

The following value types are supported for writing: strings, integers and booleans.

## Changes in this fork

This fork reworks how config writer updates files.  This writer accepts an array in write() to allow for multiple configuration values to be accepted.  This also reworks the Rewrite call to only write to each file once for efficiency.

### Usage Instructions

Add this to ```app/config/app.php``` under the 'providers' key:

```php
VirtualComplete\Config\ConfigServiceProvider::class,
```

You can now write to config files:

```
Config::write(['app.url' => 'http://octobercms.com']);
```

```
app('config')->write(['app.url' => 'http://octobercms.com']);
```

### Usage outside Laravel

The `Rewrite` class can be used anywhere.

```php
$writeConfig = new VirtualComplete\Config\Rewrite;
$writeConfig->toFile('path/to/config.php', [
    'item' => 'new value',
    'nested.config.item' => 'value'
]);
```
