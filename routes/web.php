<?php

use Begimov\Emailblacklist\Models\Email;

Route::get('/', function () {
    dd(Email::get());
});
