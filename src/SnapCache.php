<?php

namespace Senna\Utils;

class SnapCache {
    protected $values = [];

    public function put($key, $value) {
        return $this->values[$key] = $value;
    }

    public function get($key, $fallback = null)
    {
        return $this->values[$key] ?? $fallback;
    }

    public function has($key) : bool {
        return isset($this->values[$key]);
    }

    public function delete($key) : self {
        unset($this->values[$key]);

        return $this;
    }

    public function closure($closure, $args = [], $key = null) {
        if (!$key) {
            $key = serialize_callable($closure) . serialize($args);
        }

        if ($this->has($key)) {
            return $this->get($key);
        }

        return $this->put($key, $closure(...$args));
    }
}