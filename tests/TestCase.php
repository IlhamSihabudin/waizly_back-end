<?php

namespace Tests;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function createUser()
    {
        return User::factory()->create([
            'email' => 'test@gmail.com',
            'password' => Hash::make('password'),
        ]);
    }

    public function authUser()
    {
        $user = $this->createUser();
        Sanctum::actingAs($user);
        return $user;
    }

    public function todoCreate()
    {
        return Todo::factory()->create([
            'name' => 'Test Todo',
            'description' => 'Test Todo Description',
        ]);
    }
}
