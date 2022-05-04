<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;

class AchievementsController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(User $user)
    {


        $unlocked_achievements = collect($this->userService->getAllUnlockedAchievements($user))->pluck("name");

        $next_available_achievements = collect($this->userService->getAllNextAchievements($user))->pluck("name");

        $current_badge = $this->userService->getCurrentBadge($user)->name ?? "N/A";

        $next_badge = $this->userService->getNextBadge($user)->name ?? "N/A";

        $remaing_to_unlock_next_badge = $this->userService->getRemainingToUnloackNextBadge($user);

        return response()->json([
            'unlocked_achievements' => $unlocked_achievements,
            'next_available_achievements' => $next_available_achievements,
            'current_badge' => $current_badge,
            'next_badge' => $next_badge ? $next_badge : "N/A",
            'remaing_to_unlock_next_badge' => $remaing_to_unlock_next_badge
        ]);
    }
}
