<?php

namespace Begimov\Emailblacklist\Traits;

use Illuminate\Database\Eloquent\Model;
use Begimov\Emailblacklist\Models\Email;

trait Blacklistable
{
    public function blacklist($emails = null)
    {
        foreach ($this->prepare($emails) as $email) {
            Email::firstOrCreate(['email' => $email]);
        }
    }

    public function isBlacklisted(string $email = '')
    {
        return Email::whereIn('email', $this->prepare($email))
            ->get()
            ->isNotEmpty();
    }

    public function whitelist($emails = null)
    {
        Email::whereIn('email', $this->prepare($emails))
            ->delete();
    }

    private function prepare($emails)
    {
        if (empty($emails)) {  
            return $this->email 
                ? $this->validate($this->normalize([$this->email])) 
                : [];
        }

        if (is_string($emails)) {
            return $this->validate($this->normalize([$emails]));
        }

        if (is_array($emails)) {
            return $this->validate($this->normalize($emails));
        }

        return [];
    }

    private function normalize(array $emails)
    {
        return array_map(function($email) {
            return strtolower(trim($email));
        }, $emails);
    }

    private function validate(array $emails)
    {
        // validate after filtering
        return $this->filter($emails);
    }

    private function filter(array $emails)
    {
        return array_filter($emails, function($email) {
            return !empty($email);
        });
    }
}
