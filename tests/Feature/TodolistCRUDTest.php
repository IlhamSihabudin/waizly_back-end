<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TodolistCRUDTest extends TestCase
{
    public function test_user_can_create_todolist()
    {
        $this->authUser();
        $response = $this->postJson('/api/todo', [
            'name' => 'Test Todo',
            'description' => 'Test Todo Description',
        ]);

        $response->assertStatus(200);
    }

    public function test_user_can_update_todolist()
    {
        $this->authUser();
        $this->todoCreate();
        $response = $this->postJson('/api/todo/1/update', [
            'name' => 'Test Todo Updated',
            'description' => 'Test Todo Description Updated',
        ]);

        $response->assertStatus(200);
    }

    public function test_user_can_delete_todolist()
    {
        $this->authUser();
        $this->todoCreate();
        $response = $this->deleteJson('/api/todo/1');

        $response->assertStatus(200);
    }

    public function test_user_can_get_todolist()
    {
        $this->authUser();
        $this->todoCreate();
        $response = $this->getJson('/api/todo');

        $response->assertStatus(200);
    }

    public function test_user_can_get_todolist_search()
    {
        $this->authUser();
        $this->todoCreate();
        $response = $this->getJson('/api/todo?search?name=Test Todo');

        $response->assertStatus(200);
    }

    public function test_user_can_get_todolist_by_id()
    {
        $this->authUser();
        $this->todoCreate();
        $response = $this->getJson('/api/todo/1');

        $response->assertStatus(200);
    }

    public function test_user_can_set_done_todolist()
    {
        $this->authUser();
        $this->todoCreate();
        $response = $this->postJson('/api/todo/1/done');

        $response->assertStatus(200);
    }
}
