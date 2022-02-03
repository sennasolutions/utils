<?php

namespace Senna\Utils\Services;

class BaseService
{
    public static function resolve() : static {
        return resolve(get_called_class());
    }
}
