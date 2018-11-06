<?php

class StringUsageTest extends TestCase
{
    protected $user;

    public function setUp()
    {
        parent::setUp();

        $this->user = \UserStub::create([
            'email' => 'begimov@gmail.com'
        ]);
    }

    /** @test */
    public function can_blacklist_user()
    {
        $email = $this->user->email;

        $this->user->blacklist();

        $this->assertDatabaseHas('blacklist', [
            'email' => $email
        ]);
    }

    /** @test */
    public function can_blacklist_using_email_as_string()
    {
        $email = $this->user->email;

        $this->user->blacklist($email);

        $this->assertDatabaseHas('blacklist', [
            'email' => $email
        ]);
    }

    /** @test */
    public function can_blacklist_using_array_of_emails()
    {
        $email = $this->user->email;

        $user = \UserStub::create([
            'email' => 'begimov@aideus.com'
        ]);

        $this->user->blacklist([$email, $user->email]);

        $this->assertDatabaseHas('blacklist', [
            'email' => $email
        ])->assertDatabaseHas('blacklist', [
            'email' => $user->email
        ]);
    }

    /** @test */
    public function cant_blacklist_using_invalid_email_as_string()
    {
        $this->user->blacklist('invalid@email');

        $this->assertEquals(\EmailStub::all()->count(), 0);
    }

    /** @test */
    public function cant_blacklist_using_array_of_partially_invalid_emails()
    {
        $this->user->blacklist(['invalid@email', 'valid@email.com']);

        $this->assertEquals(\EmailStub::all()->count(), 0);
    }
}