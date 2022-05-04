<?php

namespace App\Repositories;

use App\Models\Comment;
use App\Models\Lesson;

class CommentRepository extends BaseRepository
{

    public function getFieldsSearchable()
    {
        return ["id", "user_id"];
    }


    public function model()
    {
        return Comment::class;
    }
}
