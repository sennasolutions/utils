<?php

use App\Models\User;

function user($guard = null) : ?User
{
    return auth($guard)->user();
}
