<?php

namespace Database\Seeders;

use App\Repositories\BadgeRepository;
use App\Repositories\CommentAchievementRepository;
use App\Repositories\LessonAchievementRepository;
use Illuminate\Database\Seeder;

class AchievementsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        /** @var LessonAchievementRepository */
        $lesson_achievement_repo = app(LessonAchievementRepository::class);

        /** @var CommentAchievementRepository */
        $comment_achievement_repo = app(CommentAchievementRepository::class);

        /** @var BadgeRepository */
        $badge_repo = app(BadgeRepository::class);



        $lesson_achievements = config("achievements.lesson_achievements");

        $comment_achievements = config("achievements.comment_achievements");

        $badges = config("achievements.badges");



        //Add lesson achievments
        foreach ($lesson_achievements as $lesson_achievement) {
            $alreadyExists = $lesson_achievement_repo->allQuery()
                ->where($lesson_achievement)
                ->exists();
            if (!$alreadyExists)
                $lesson_achievement_repo->create($lesson_achievement);
        }


        //Add comments achievments
        foreach ($comment_achievements as $comment_achievement) {
            $alreadyExists = $comment_achievement_repo->allQuery()
                ->where($comment_achievement)
                ->exists();
            if (!$alreadyExists)
                $comment_achievement_repo->create($comment_achievement);
        }

        //add badges
        foreach ($badges as $badge) {
            $alreadyExists = $badge_repo->allQuery()
                ->where($badge)
                ->exists();
            if (!$alreadyExists)
                $badge_repo->create($badge);
        }
    }
}
