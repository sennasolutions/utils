<?php

namespace Senna\Utils\Livewire\Traits;

use Exception;

trait WithMethodProtection
{
    protected function initializeWithMethodProtection()
    {
        if (!method_exists($this, 'callable') && !property_exists($this, 'callable')) {
            throw new Exception("The `\$callable` array must be present on component '{$this->getName()}'");
        }
    }
    
    public function callMethod($method, $params = [], $captureReturnValueCallback = null)
    {
        $method = trim($method);

        // ['$set','$sync','$toggle','$refresh']
        // what does $sync do?
        if (method_exists($this, $method)) {
            $callable = $this->getCallableMethods();

            if ($method && !in_array($method, $callable)) {
                throw new Exception("Method '{$method}' is not allowed to be called on component '{$this->getName()}'. Allow it by setting the `\$callable` array.");
            }
        }

        parent::callMethod($method, $params, $captureReturnValueCallback);
    }

    protected function getCallableMethods()
    {
        if (method_exists($this, 'callable')) return $this->callable();
        if (property_exists($this, 'callable')) return $this->callable;

        return [];
    }
}
