<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class SocialLogin extends Authenticatable
{
    protected $guarded = [];
}
