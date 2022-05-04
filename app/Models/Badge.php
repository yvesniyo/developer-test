<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Badge
 * @package App\Models
 *
 * @property int $id
 * @property string $name
 * @property int $achievements
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */

class Badge extends Model
{
    use HasFactory;

    protected $fillable = ["name", "achievements"];
}
