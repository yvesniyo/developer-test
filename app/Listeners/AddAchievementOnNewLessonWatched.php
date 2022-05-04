<?php

namespace App\Listeners;

use App\Events\AchievementUnlocked;
use App\Events\BadgeUnlocked;
use App\Events\LessonWatched;
use App\Services\UserService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AddAchievementOnNewLessonWatched
{
    private UserService $userService;


    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(
        UserService $userService
    ) {
        $this->userService = $userService;
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\LessonWatched  $event
     * @return void
     */
    public function handle(LessonWatched $event)
    {
        $user = $event->user;
        $lesson = $event->lesson;


        $all_user_lessons = $user->watched()->count();

        //see if this is the new badge to be given
        $currentBadge = $this->userService->getCurrentBadge($user);
        $badgeAchievements = $currentBadge->achievements;
        $allAchievements = count($this->userService->getAllUnlockedAchievements($user));

        if ($badgeAchievements == $allAchievements) {
            event(new BadgeUnlocked($currentBadge->name, $user));
        }


        //see if there is a new achievement on lessons
        /** @var \App\Models\LessonAchievement */
        $currentAchievement = collect($this->userService->getUnlockedLessonsAchievements($user))
            ->last();

        if (
            $currentAchievement &&
            $currentAchievement->watches == $all_user_lessons
        ) {
            event(new AchievementUnlocked($currentAchievement->name, $user));
        }
    }
}
