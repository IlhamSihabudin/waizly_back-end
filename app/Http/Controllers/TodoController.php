<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Http\Requests\Todo\TodoCreate;
use App\Http\Requests\Todo\TodoUpdate;
use App\Models\Todo;
use App\Repositories\TodoRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TodoController extends Controller
{
    public function __construct()
    {
        request()->headers->set("Accept", "application/json");
    }

    /**
     * Get the repository instance.
     *
     * @return \App\Repositories\TodoRepository
     */
    public function repo()
    {
        return new TodoRepository();
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        try {
            Log::info('User is accessing all the Todos', ['user' => auth()->id()]);
            return ResponseFormatter::success($this->repo()->getData($request->search));
        }catch (\Exception $e) {
            Log::error('Error while accessing all the Todos', ['user' => auth()->id(), 'error' => $e->getMessage()]);
            return ResponseFormatter::error(null, $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TodoCreate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(TodoCreate $request)
    {
        try {
            Log::info('User is creating a Todo', ['user' => auth()->id()]);
            return ResponseFormatter::success($this->repo()->create($request->all()), 'Todo created successfully');
        }catch (\Exception $e) {
            Log::error('Error while creating a Todo', ['user' => auth()->id(), 'error' => $e->getMessage()]);
            return ResponseFormatter::error(null, $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Todo $todo
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Todo $todo)
    {
        try {
            Log::info('User is accessing a Todo', ['user' => auth()->id(), 'todo' => $todo->id]);
            return ResponseFormatter::success($todo, 'Todo retrieved successfully');
        }catch (\Exception $e) {
            Log::error('Error while accessing a Todo', ['user' => auth()->id(), 'todo' => $todo->id, 'error' => $e->getMessage()]);
            return ResponseFormatter::error(null, $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Todo $todo
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(TodoUpdate $request, Todo $todo)
    {
        try {
            Log::info('User is updating a Todo', ['user' => auth()->id(), 'todo' => $todo->id]);
            return ResponseFormatter::success($this->repo()->updateById($todo->id, $request->all()), 'Todo updated successfully');
        }catch (\Exception $e) {
            Log::error('Error while updating a Todo', ['user' => auth()->id(), 'todo' => $todo->id, 'error' => $e->getMessage()]);
            return ResponseFormatter::error(null, $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Todo $todo
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Todo $todo)
    {
        try {
            Log::info('User is deleting a Todo', ['user' => auth()->id(), 'todo' => $todo->id]);
            return ResponseFormatter::success($this->repo()->deleteById($todo->id), 'Todo deleted successfully');
        }catch (\Exception $e) {
            Log::error('Error while deleting a Todo', ['user' => auth()->id(), 'todo' => $todo->id, 'error' => $e->getMessage()]);
            return ResponseFormatter::error(null, $e->getMessage());
        }
    }

    /**
     * Set todo done.
     *
     * @param Todo $todo
     * @return \Illuminate\Http\JsonResponse
     */
    public function setDone(Todo $todo)
    {
        try {
            Log::info('User is setting a Todo done', ['user' => auth()->id(), 'todo' => $todo->id]);
            return ResponseFormatter::success($this->repo()->setDone($todo), 'Todo set done successfully');
        }catch (\Exception $e) {
            return ResponseFormatter::error(null, $e->getMessage());
        }
    }
}
