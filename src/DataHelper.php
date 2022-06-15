<?php

namespace Senna\Utils;


/**
 * This is a helper for writing/reading array data in a model with support for the deep dot-notation.
 * 
 * @example $model->set('data.wishes', [
 *    'function' => 'Webdeveloper'
 * ]);
 */
class DataHelper
{
    public function __construct(public &$model) {}

    public static function target(&$model) : DataHelper
    {
        return new static($model);
    }

    public function beforeFirstDot($subject)
    {
        return head(explode('.', $subject));
    }

    public function containsDots($subject)
    {
        return strpos($subject, '.') !== false;
    }

    public function afterFirstDot($subject) : string
    {
        return str($subject)->after('.');
    }

    public function set(string $key, $value) : DataHelper
    {
        $valueBefore = $this->model->{$this->beforeFirstDot($key)} ?? [];

        if ($this->containsDots($key)) {
            $value = data_set($valueBefore, $this->afterFirstDot($key), $value);
        }

        $this->model->{$this->beforeFirstDot($key)} = $value;
        
        return $this;
    }

    public function get(string $key, $default = null)
    {
        $value = $this->model->{$this->beforeFirstDot($key)};

        if ($this->containsDots($key)) {
            $value = data_get($value, $this->afterFirstDot($key));
        }

        return $value ?? $default;
    }
    
    public function appendTo(string $key, $value) : DataHelper
    {
        $data = $this->get($key, []);
        $data[] = $value;

        return $this->set($key, $data);
    }

    public function prependTo(string $key, $value) : DataHelper
    {
        $data = $this->get($key, []);
        array_unshift($data, $value);

        return $this->set($key, $data);
    }

    public function remove(string $key) : DataHelper
    {
        return $this->set($key, null);
    }

    public function removeAt(string $key, $index) : DataHelper
    {
        $data = $this->get($key, []);
        $isArray = is_array($data);

        
        if ($isArray) {
            unset($data[$index]);
            $data = array_values($data);
        } else {
            unset($data->{$index});
        }

        return $this->set($key, $data);
    }

    public function save()
    {
        $this->model->save();
    }
}
