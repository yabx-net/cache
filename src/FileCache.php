<?php

namespace Yabx\Cache;

class FileCache implements CacheInterface {

    private const ATTR_VALUE = 'v';
    private const ATTR_EXPIRES = 'e';

    private string $dataPath;

    public function __construct(string $dataPath) {
        $this->dataPath = $dataPath;
    }

    public function set(string $key, mixed $value, ?int $ttl = null): bool {
        $path = $this->getFilePath($key);
        $dir = pathinfo($path, PATHINFO_DIRNAME);
        if(!is_dir($dir)) {
            if(!mkdir($dir, 0755, true)) return false;
        }
        $value = [
            self::ATTR_VALUE => $value,
            self::ATTR_EXPIRES => $ttl ? time() + $ttl : null,
        ];
        return (bool)file_put_contents($path, serialize($value));
    }

    public function get(string $key): mixed {
        $path = $this->getFilePath($key);
        if(!file_exists($path)) return null;
        $data = unserialize(file_get_contents($path));
        if($data[self::ATTR_EXPIRES] && $data[self::ATTR_EXPIRES] < time()) {
            $this->delete($key);
            return null;
        }
        return $data[self::ATTR_VALUE];
    }

    public function delete(string $key): bool {
        $path = $this->getFilePath($key);
        if(!file_exists($path)) return false;
        return unlink($path);
    }

    private function getFilePath(string $key): string {
        $hash = md5($key);
        return sprintf('%s/%s/%s/%s.dat', $this->dataPath, substr($hash, 0, 2), substr($hash, 2, 2), $hash);
    }

}
