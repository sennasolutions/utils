<?php

namespace Senna\Utils\Helpers;

use Closure;
use Illuminate\Support\Facades\Cache;

class CacheHelper {

    public function __construct(
        public ?string $key = null, 
        public ?Closure $closure = null, 
        public \DateTimeInterface|\DateInterval|int $ttl = 0)
    {
   
    }

    /**
     * remember a closure
     *
     * @param Closure $closure
     * @return self
     */
    public function closure(Closure $closure) : self {
        $this->closure = $closure;
        return $this;
    }

    public function key(mixed ...$key) : self {
        $this->key = serialize($key);
        return $this;
    }

    public function ttl(\DateTimeInterface|\DateInterval|int $seconds) : self {
        $this->ttl = $seconds;
        return $this;
    }

    public function remember() : mixed {
        if (!$this->key) {
            throw new \Exception('No key set');
        }

        if (!$this->closure) {
            throw new \Exception('No closure set');
        }

        return Cache::remember($this->key, $this->ttl, $this->closure);
    }

    public function rememberFor(\DateTimeInterface|\DateInterval|int $seconds) : mixed {
        return $this->ttl($seconds)->remember();
    }
    
    public function rememberForever() : mixed {
        return Cache::rememberForever($this->key, $this->closure);
    }
}

/**
 * Wrapper arround the cache remember function with the option to provide other date structs for keys
 *
 * @param mixed $key
 * @param integer $seconds
 * @param Closure $closure
 * 
 * @return CacheHelper
 */
function cached(Closure $closure) : CacheHelper
{
    return (new CacheHelper)->closure($closure);
}

/**
 * Serialize a key
 *
 * @param mixed ...$key
 * @return string
 */
function cached_key(mixed ...$key) : string {
    return serialize($key);
}