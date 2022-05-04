<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


/**
 * Class LessonUser
 * @package App\Models
 *
 * @property int $user_id
 * @property int $lesson_id
 * @property bool $watched
 * @property \App\Models\User $user
 * @property \App\Models\Lesson $lesson
 */
class LessonUser extends Model
{

    protected $table = "lesson_user";

    protected $fillable = ["watched", "user_id", "lesson_id"];

    public $timestamps = false;

    /**
     * User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    /**
     * Lesson
     */
    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }
}
