<?php

namespace Yabx\Cache;

use Redis;

class RedisCache implements CacheInterface {

    protected Redis $redis;
    protected ?string $prefix;

    public function __construct(Redis $redis, string $prefix = null) {
        $this->redis = $redis;
        $this->prefix = $prefix;
    }

    public function set(string $key, mixed $value, ?int $ttl = null): bool {
        return (bool)$this->redis->set($this->prefix . $key, serialize($value), $ttl);
    }

    public function get(string $key): mixed {
        if($data = $this->redis->get($this->prefix . $key)) {
            return unserialize($data);
        }  else {
            return null;
        }
    }

    public function delete(string $key): bool {
        return (bool)$this->redis->del($this->prefix . $key);
    }

}
