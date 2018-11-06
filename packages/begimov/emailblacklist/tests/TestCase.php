<?php

use Begimov\Emailblacklist\Providers\EmailBlacklistServiceProvider;

abstract class TestCase extends Orchestra\Testbench\TestCase
{
    public function setUp()
    {
        parent::setUp();

        Eloquent::unguard();

        $this->artisan('migrate', [
            '--database' => 'testbench',
            '--realpath' => realpath(__DIR__ . '/../migrations/'),
        ])->run();
    }

    public function tearDown()
    {
        \Schema::drop('users');
    }

    protected function getPackageProviders($app)
    {
        return [
            EmailBlacklistServiceProvider::class
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'testbench');

        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);

        \Schema::create('users', function($table) {
            $table->increments('id');
            $table->string('email')->unique();
            $table->timestamps();
        });
    }
}