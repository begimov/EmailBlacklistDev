<?php

use App\User;

Route::get('/', function () {
    dd(User::find(1)->isBlacklisted('aaaa'));
});
