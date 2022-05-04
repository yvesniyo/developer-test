<?php

namespace App\Repositories;

use App\Models\Lesson;

class LessonRepository extends BaseRepository
{

    public function getFieldsSearchable()
    {
        return ["id", "title"];
    }


    public function model()
    {
        return Lesson::class;
    }
}
