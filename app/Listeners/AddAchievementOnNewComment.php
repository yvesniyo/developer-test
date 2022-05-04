<?php

namespace App\Listeners;

use App\Events\AchievementUnlocked;
use App\Events\BadgeUnlocked;
use App\Events\CommentWritten;
use App\Services\UserService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AddAchievementOnNewComment
{
    private UserService $userService;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\CommentWritten  $event
     * @return void
     */
    public function handle(CommentWritten $event)
    {
        $comment = $event->comment;

        $user = $comment->user;
        $all_user_comments = $user->comments()->count();


        //see if this is the new badge to be given
        $currentBadge = $this->userService->getCurrentBadge($user);
        $badgeAchievements = $currentBadge->achievements;
        $allAchievements = count($this->userService->getAllUnlockedAchievements($user));

        if ($badgeAchievements == $allAchievements) {
            event(new BadgeUnlocked($currentBadge->name, $user));
        }

        //see if there is a new achievement on comment
        /** @var \App\Models\CommentAchievement */
        $currentAchievement = collect($this->userService->getUnlockedCommentsAchievements($user))
            ->last();

        if (
            $currentAchievement &&
            $currentAchievement->comments == $all_user_comments
        ) {
            event(new AchievementUnlocked($currentAchievement->name, $user));
        }
    }
}
