<?php

namespace App\Repositories;


use App\Models\User;

class UserRepository extends BaseRepository
{

    public function getFieldsSearchable()
    {
        return ["id", "name", "email", "remember_token"];
    }


    public function model()
    {
        return User::class;
    }
}
