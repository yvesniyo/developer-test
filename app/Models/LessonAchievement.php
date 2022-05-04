<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LessonAchievement
 * @package App\Models
 *
 * @property int $id
 * @property string $name
 * @property int $watches
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class LessonAchievement extends Model
{
    use HasFactory;

    protected $table = "lesson_achievements";
}
