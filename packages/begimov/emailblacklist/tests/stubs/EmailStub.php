<?php

use Illuminate\Database\Eloquent\Model;

class EmailStub extends Model
{
    protected $connection = 'testbench';

    public $table = 'blacklist';
}
