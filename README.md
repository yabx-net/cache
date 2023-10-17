Simple Cache Implementation for PHP 8.0+
--------------------------------------
- CacheInterface (cache interface)
- FileCache (file cache implementation)
- RedisCache (Redis cache implementation)

Installation
------------
```shell
composer req yabx/cache
```

Simple usage
------------
```php
<?php

use Yabx\Cache\FileCache;
use Yabx\Cache\RedisCache;

// FileCache
$cache = new FileCache(__DIR__ . '/cache');

// or RedisCache  
$redis = new Redis;
$redis->connect('localhost');
$cache = new RedisCache($redis, 'prefix:');

// Setting value (3600 seconds live period)
$cache->set('key', $value, 3600);

// Getting value by key
$value = $cache->get('key');

// Deleting value by key
$cache->delete('key');
```
Example
------------
```php
<?php

// ....

$key = 'calculated';

// Checking for cached item with $key
if(!$value = $cache->get($key)) {
    // Hardworking for calculate value
    $value = calc(....);
    $cache->set($key, $value, 3600);
}

// Displing value
echo $value;
```
