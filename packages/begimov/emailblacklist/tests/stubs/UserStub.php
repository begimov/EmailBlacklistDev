<?php

use Begimov\Emailblacklist\Traits\Blacklistable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UserStub extends Authenticatable
{
    use Blacklistable;

    protected $connection = 'testbench';

    public $table = 'users';
}
