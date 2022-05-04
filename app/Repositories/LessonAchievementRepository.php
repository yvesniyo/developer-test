<?php

namespace App\Repositories;

use App\Models\LessonAchievement;

class LessonAchievementRepository extends BaseRepository
{

    public function getFieldsSearchable()
    {
        return ["id", "name", "watches"];
    }


    public function model()
    {
        return LessonAchievement::class;
    }
}
