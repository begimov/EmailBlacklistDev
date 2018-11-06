Laravel package to create and maintain email blacklist.
==============

## Installation
To install through composer, put the following in your composer.json file:

```json
{
    "require-dev": {
        "begimov/emailblacklist": "^1.0"
    }
}
```

And then run composer install from the terminal.

or execute:

    composer require begimov/emailblacklist

## Usage

To use Component, all you need to do is add `Begimov\Emailblacklist\Traits\Blacklistable` trait to class.

```php
<?php

use Begimov\Emailblacklist\Traits\Blacklistable;

class User extends Authenticatable
{
    use Blacklistable;
}
```

After that you can blacklist current user.

```php
$user->blacklist();
```

Blacklist specific email.

```php
$this->blacklist('valid@email.com');
```

Blacklist several emails.

```php
$this->blacklist(['valid1@email.com', 'valid2@email.com']);
```

Whitelist emails using same approach.

```php
$user->whitelist();
$this->whitelist('valid@email.com');
$this->whitelist(['valid1@email.com', 'valid2@email.com']);
```

And check if email is blacklisted.

```php
$user->isBlacklisted();
$this->isBlacklisted('valid@email.com');
```