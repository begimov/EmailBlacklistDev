<?php

namespace Begimov\Emailblacklist\Traits;

use Illuminate\Database\Eloquent\Model;
use Begimov\Emailblacklist\Models\Email;
use Illuminate\Support\Facades\Validator;

trait Blacklistable
{
    protected $validationRules = [
        'required', 'string', 'email', 'max:255'
    ];

    /**
     * Add emails to blacklist.
     *
     * @param  mixed $emails
     * @return void
     */
    public function blacklist($emails = null)
    {
        foreach ($this->prepare($emails) as $email) {
            Email::firstOrCreate(['email' => $email]);
        }
    }

    /**
     * Check if email is blacklisted.
     *
     * @param  string $email
     * @return void
     */
    public function isBlacklisted(string $email = '')
    {
        return Email::whereIn('email', $this->prepare($email))
            ->get()
            ->isNotEmpty();
    }

    /**
     * Remove emails from blacklist.
     *
     * @param  mixed $email
     * @return void
     */
    public function whitelist($emails = null)
    {
        Email::whereIn('email', $this->prepare($emails))
            ->delete();
    }

    /**
     * Preparing data for futher processing.
     *
     * @param  mixed $emails
     * @return array
     */
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

    /**
     * Normalizing array of emails.
     *
     * @param  array $emails
     * @return array
     */
    private function normalize(array $emails)
    {
        return array_map(function($email) {
            return ['email' => strtolower(trim($email))];
        }, $emails);
    }

    /**
     * Validating array of emails
     *
     * @param  array $emails
     * @return array
     */
    private function validate(array $emails)
    {
        $validator = Validator::make($filteredEmails = $this->filter($emails), [
            '*.email' => $this->validationRules
        ]);

        if ($validator->fails()) {
            return [];
        }

        return array_flatten($filteredEmails);
    }

    /**
     * Filtering out useless data.
     *
     * @param  array $emails
     * @return array
     */
    private function filter(array $emails)
    {
        return array_filter($emails, function($email) {
            return !empty($email);
        });
    }
}
