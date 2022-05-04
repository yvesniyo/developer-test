<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * Class CommentAchievement
 * @package App\Models
 *
 * @property int $id
 * @property string $name
 * @property int $comments
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class CommentAchievement extends Model
{
    use HasFactory;


    protected $table = "comment_achievements";
}
