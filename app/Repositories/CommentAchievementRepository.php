<?php

namespace App\Repositories;

use App\Models\CommentAchievement;

class CommentAchievementRepository extends BaseRepository
{

    public function getFieldsSearchable()
    {
        return ["id", "name"];
    }


    public function model()
    {
        return CommentAchievement::class;
    }
}
