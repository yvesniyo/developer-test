<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\BadgeRepository;
use App\Repositories\CommentAchievementRepository;
use App\Repositories\LessonAchievementRepository;

class UserService
{
    private CommentAchievementRepository $commentAchievementRepository;
    private LessonAchievementRepository $lessonAchievementRepository;
    private BadgeRepository $badgeRepository;

    public function __construct(
        CommentAchievementRepository $commentAchievementRepository,
        LessonAchievementRepository $lessonAchievementRepository,
        BadgeRepository $badgeRepository
    ) {

        $this->commentAchievementRepository = $commentAchievementRepository;
        $this->lessonAchievementRepository = $lessonAchievementRepository;
        $this->badgeRepository = $badgeRepository;
    }


    public function getUnlockedCommentsAchievements(User $user)
    {
        /** @var int */
        $comments = $user->comments()->count();

        return self::COMMENTS_TO_ACHIEVEMENTS($comments);
    }

    public function getUnlockedLastCommentsAchievement(User $user)
    {
        /** @var \App\Models\CommentAchievement | null */
        $achievement = collect($this->getUnlockedCommentsAchievements($user))->last();

        return $achievement;
    }

    public function getNextCommentAchievments(User $user)
    {

        $unlocked = collect($this->getUnlockedCommentsAchievements($user));

        $comment_achievements = $this->commentAchievementRepository->all();


        /** @var \App\Models\CommentAchievement[] */
        $next_achievements = $comment_achievements->diff($unlocked);

        return $next_achievements;
    }

    public function getNextLesssonAchievments(User $user)
    {

        $unlocked = collect($this->getUnlockedLessonsAchievements($user));

        $lesson_achievements = $this->lessonAchievementRepository->allQuery()
            ->orderBy("watches", "asc")
            ->get();


        /** @var \App\Models\LessonAchievement[] */
        $next_achievements = $lesson_achievements->diff($unlocked);

        return $next_achievements;
    }


    public function getUnlockedLessonsAchievements(User $user)
    {
        /** @var int */
        $watches = $user->watched()->count();

        return self::LESSON_WATCHED_TO_ACHIEVEMENTS($watches);
    }

    public function getUnlockedLastLessonsAchievement(User $user)
    {
        /** @var \App\Models\LessonAchievement | null */
        $achievement = collect($this->getUnlockedLessonsAchievements($user))->last();

        return $achievement;
    }

    public  function getUnlockedBadges(User $user)
    {
        $user_comments_achievements = $this->getUnlockedCommentsAchievements($user);
        $user_lessons_achievements = $this->getUnlockedLessonsAchievements($user);

        $badges = $this->badgeRepository->allQuery()
            ->orderBy("achievements", "asc")
            ->get();

        $all_achievments = count($user_comments_achievements) + count($user_lessons_achievements);

        /** @var \App\Models\Badge[] */
        $user_achieved_badges = [];



        /** @var \App\Models\Badge @badge */
        foreach ($badges as $badge) {
            if ($all_achievments >= $badge->achievements) {
                $user_achieved_badges[] = $badge;
            }
        }

        return $user_achieved_badges;
    }

    public function getNextBadges(User $user)
    {

        $unlocked = collect($this->getUnlockedBadges($user));

        $badges_achievements = $this->badgeRepository->allQuery()
            ->orderBy("achievements", "asc")
            ->get();


        /** @var \App\Models\Badge[] */
        $next_badges = $badges_achievements->diff($unlocked);

        return $next_badges;
    }

    public function getCurrentBadge(User $user): \App\Models\Badge
    {
        $badges = collect($this->getUnlockedBadges($user));

        return $badges->last();
    }

    /**
     * @return \App\Models\Badge | null
     */
    public function getNextBadge(User $user)
    {
        $badges = collect($this->getNextBadges($user));

        if ($badges->count()) {
            return $badges->first();
        }

        return null;
    }


    public function getAllUnlockedAchievements(User $user)
    {


        $comments =  collect($this->getUnlockedCommentsAchievements($user));
        $lessons = collect($this->getUnlockedLessonsAchievements($user));

        /** @var \App\Models\LessonAchievement[] | \App\Models\CommentAchievement[] */
        $result = $comments->merge($lessons);
        return $result;
    }


    public function getAllNextAchievements(User $user)
    {

        /** @var string[] */
        $result = [];

        $comment =  collect($this->getNextCommentAchievments($user))->first();
        $lesson = collect($this->getNextLesssonAchievments($user))->first();

        if ($lesson) {
            $result[] = $lesson;
        }

        if ($comment) {
            $result[] = $comment;
        }



        return $result;
    }


    public function getRemainingToUnloackNextBadge(User $user)
    {
        $next_badge = $this->getNextBadge($user);
        $comments =  collect($this->getUnlockedCommentsAchievements($user))->count();
        $lessons = collect($this->getUnlockedLessonsAchievements($user))->count();

        $all_achievments_sum = $comments + $lessons;


        if ($next_badge) {

            $badges_achievements = $next_badge->achievements;

            return $badges_achievements - $all_achievments_sum;
        }

        return 0;
    }

    public static function LESSON_WATCHED_TO_ACHIEVEMENTS(int $watches = 1)
    {


        $lesson_achievements = app(LessonAchievementRepository::class)->allQuery()
            ->orderBy("watches", "asc")
            ->get();


        /** @var \App\Models\LessonAchievement[] */
        $user_achievements = [];

        /** @var \App\Models\LessonAchievement @comment_achievement */
        foreach ($lesson_achievements as $watched_achievement) {

            if ($watches >= $watched_achievement->watches) {

                $user_achievements[] = $watched_achievement;
            }
        }

        return $user_achievements;
    }

    public static function COMMENTS_TO_ACHIEVEMENTS(int $comments = 1)
    {

        $comment_achievements = app(CommentAchievementRepository::class)->all();

        /** @var \App\Models\CommentAchievement[] */
        $user_achievements = [];

        /** @var \App\Models\CommentAchievement @comment_achievement */
        foreach ($comment_achievements as $comment_achievement) {

            if ($comments >= $comment_achievement->comments) {

                $user_achievements[] = $comment_achievement;
            }
        }

        return $user_achievements;
    }
}
