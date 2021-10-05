<?php

namespace Senna\Utils;

use Closure;
use ReflectionFunction;

function serialize_callable(callable $callable) {
    if($callable instanceof Closure) {
      $r = new ReflectionFunction($callable);

      return serialize([
          $r->getFileName(),
          $r->getStartLine(),
          $r->getEndLine(),
      ]);
    }

    if(is_callable($callable)) {
      return serialize($callable);
    }

    return null;
}