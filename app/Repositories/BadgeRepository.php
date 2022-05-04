<?php

namespace App\Repositories;

use App\Models\Badge;

class BadgeRepository extends BaseRepository
{

    public function getFieldsSearchable()
    {
        return ["name"];
    }


    public function model()
    {
        return Badge::class;
    }
}
