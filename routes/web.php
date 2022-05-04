<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AchievementsController;
use App\Models\User;
use App\Repositories\LessonAchievementRepository;
use App\Services\UserService;

Route::get('/users/{user}/achievements', [AchievementsController::class, 'index']);
