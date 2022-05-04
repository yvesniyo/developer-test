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


        /*
        - First Lesson Watched
        - 5 Lessons Watched
        - 10 Lessons Watched
        - 25 Lessons Watched
        - 50 Lessons Watched
        */

        $lesson_achievements = [
            [
                "name" => "First Lesson Watched",
                "watches" => 1,
            ],
            [
                "name" => "5 Lessons Watched",
                "watches" => 5,
            ],
            [
                "name" => "10 Lessons Watched",
                "watches" => 10,
            ],
            [
                "name" => "25 Lessons Watched",
                "watches" => 25,
            ],
            [
                "name" => "50 Lessons Watched",
                "watches" => 50,
            ],
        ];



        /*
        - First Comment Written
        - 3 Comments Written
        - 5 Comments Written
        - 10 Comment Written
        - 20 Comment Written
         */
        $comment_achievements = [
            [
                "name" => "First Comment Written",
                "comments" =>  1,
            ],
            [
                "name" => "3 Comments Written",
                "comments" =>  3,
            ],
            [
                "name" => "5 Comments Written",
                "comments" =>  5,
            ],
            [
                "name" => "10 Comments Written",
                "comments" =>  10,
            ], [
                "name" => "20 Comments Written",
                "comments" =>  20,
            ]
        ];

        /*
        - Beginner: 0 Achievements
        - Intermediate: 4 Achievements
        - Advanced: 8 Achievements
        - Master: 10 Achievements
        */
        $badges = [
            [
                "name" => "Beginner",
                "achievements" => 0,
            ],
            [
                "name" => "Intermediate",
                "achievements" => 4,
            ],
            [
                "name" => "Advanced",
                "achievements" => 8,
            ],
            [
                "name" => "Master",
                "achievements" =>  10,
            ],

        ];




        //Add lesson achievments
        foreach ($lesson_achievements as $lesson_achievement) {
            $lesson_achievement_repo->create($lesson_achievement);
        }


        //Add comments achievments
        foreach ($comment_achievements as $comment_achievement) {
            $comment_achievement_repo->create($comment_achievement);
        }

        //add badges
        foreach ($badges as $badge) {
            $badge_repo->create($badge);
        }
    }
}
