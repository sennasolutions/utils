<?php

use Senna\Admin\Interfaces\SennaUser;

function user($guard = null) : ?SennaUser
{
    return auth($guard)->user();
}
