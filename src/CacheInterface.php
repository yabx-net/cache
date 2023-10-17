<?php

namespace Yabx\Cache;

interface CacheInterface {

    public function set(string $key, mixed $value, ?int $ttl = null): bool;

    public function get(string $key): mixed;

    public function delete(string $key): bool;

}
