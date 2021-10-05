<?php

namespace Senna\Utils;

class SnapCache {
    protected $values = [];

    public function put($key, $value) {
        $key = $this->processKey($key);
        return $this->values[$key] = $value;
    }

    public function get($key, $fallback = null)
    {
        $key = $this->processKey($key);
        return $this->values[$key] ?? $fallback;
    }

    public function has($key) : bool {
        $key = $this->processKey($key);
        return isset($this->values[$key]);
    }

    public function clear($key) : self {
        $key = $this->processKey($key);

        unset($this->values[$key]);

        return $this;
    }

    public function closure($closure, $key, $args = []) {
        $key = $this->processKey($key);

        if ($this->has($key)) {
            return $this->get($key);
        }

        return $this->put($key, $closure(...$args));
    }

    private function processKey($key)
    {
        if (!is_string($key)) {
            $key = serialize($key);
        }
        return $key;
    }
}
