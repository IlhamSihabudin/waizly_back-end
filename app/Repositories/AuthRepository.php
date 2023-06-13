<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
//use Your Model

/**
 * Class AuthRepository.
 */
class AuthRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return User::class;
    }

    public function register($datas)
    {
        return $this->model->create([
            'name'      => $datas['name'],
            'email'     => $datas['email'],
            'password'  => Hash::make($datas['password'])
        ]);
    }
}
