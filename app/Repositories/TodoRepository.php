<?php

namespace App\Repositories;

use App\Models\Todo;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
//use Your Model

/**
 * Class TodoRepository.
 */
class TodoRepository extends BaseRepository
{
    /**
     * @return Todo::class|string
     *  Return the model
     */
    public function model()
    {
        return Todo::class;
    }

    public function getData($search)
    {
        $datas = $this->model;

        if (!empty($search)) {
            $datas = $datas->where('name', 'like', "%$search%");
        }

        return $datas->orderBy('id', 'desc')->get();
    }

    public function setDone($todo)
    {
        $todo->update([
            'status' => 'done',
        ]);

        return $todo;
    }
}
