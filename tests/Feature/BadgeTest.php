<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\Lesson;
use App\Models\LessonUser;
use Tests\TestCase;
use App\Models\User;
use App\Repositories\BadgeRepository;
use App\Repositories\CommentAchievementRepository;
use App\Repositories\CommentRepository;
use App\Repositories\LessonAchievementRepository;
use App\Repositories\LessonRepository;
use App\Services\UserService;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BadgeTest extends TestCase
{

    use DatabaseTransactions;

    private CommentRepository $commentRepo;

    private LessonRepository $lessonRepo;
    private BadgeRepository $badgeRepo;

    private LessonAchievementRepository $lessonAchievementRepo;
    private CommentAchievementRepository $commentAchievementRepo;


    private UserService $userService;


    public function setUp(): void
    {
        parent::setUp();

        $this->commentRepo = app(CommentRepository::class);
        $this->lessonRepo = app(LessonRepository::class);
        $this->badgeRepo = app(BadgeRepository::class);
        $this->lessonAchievementRepo = app(LessonAchievementRepository::class);
        $this->commentAchievementRepo = app(CommentAchievementRepository::class);
        $this->userService = app(UserService::class);
    }

    private function addAchievementsToUser(User $user, int $achievements = 1)
    {

        Lesson::factory()->count(100)->create();

        $lessons = $this->lessonRepo->allQuery()->get();

        $lessons_achievements = $this->lessonAchievementRepo->allQuery()
            ->orderBy("watches", "asc")->get()->pluck("watches");
        $comments_achievements = $this->commentAchievementRepo->allQuery()
            ->orderBy("comments", "asc")->get()->pluck("comments");

        $make_lesson_achievements = $achievements > $lessons_achievements->count() ?
            $lessons_achievements[$lessons_achievements->count() - 1] :
            $lessons_achievements[$achievements - 1];


        foreach ($lessons as $key => $lesson) {

            if ($key == $make_lesson_achievements) {
                break;
            }

            LessonUser::create([
                "lesson_id" => $lesson->id,
                "user_id" => $user->id,
                "watched" => true,
            ]);
        }



        $achievements =  $achievements - $lessons_achievements->count();
        if ($achievements <= 0) {
            return;
        }

        $make_comment_achievements = $achievements > $comments_achievements->count() ?
            $comments_achievements[$comments_achievements->count() - 1] :
            $comments_achievements[$achievements - 1];


        for ($i = 0; $i < $make_comment_achievements; $i++) {
            Comment::create([
                "body" => "Testing comment",
                "user_id" => $user->id,
            ]);
        }
    }

    public function test_user_beginner_badge()
    {

        $this->seed();

        $user = User::factory()->create();

        $achievements = $this->userService->getUnlockedCommentsAchievements($user);

        $badge =  $this->userService->getCurrentBadge($user);

        $this->assertCount(0, $achievements);
        $this->assertNotEmpty($badge);
        $this->assertEquals("Beginner", $badge->name);
    }


    public function test_user_intermediate_badge()
    {

        $this->seed();

        $targetBadgeName = "Intermediate";

        $user = User::factory()->create();


        /** @var \App\Models\Badge */
        $targetBadge = $this->badgeRepo->allQuery()->where([
            "name" => $targetBadgeName
        ])->first();

        $this->addAchievementsToUser($user, $targetBadge->achievements);

        $achievements = $this->userService->getAllUnlockedAchievements($user);

        $badge =  $this->userService->getCurrentBadge($user);

        $this->assertCount($targetBadge->achievements, $achievements);
        $this->assertNotEmpty($badge);
        $this->assertEquals($targetBadgeName, $badge->name);
    }


    public function test_user_advanced_badge()
    {

        $this->seed();

        $targetBadgeName = "Advanced";

        $user = User::factory()->create();


        /** @var \App\Models\Badge */
        $targetBadge = $this->badgeRepo->allQuery()->where([
            "name" => $targetBadgeName
        ])->first();

        $this->addAchievementsToUser($user, $targetBadge->achievements);


        $achievements = $this->userService->getAllUnlockedAchievements($user);

        $badge =  $this->userService->getCurrentBadge($user);

        $this->assertCount($targetBadge->achievements, $achievements);
        $this->assertNotEmpty($badge);
        $this->assertEquals($targetBadgeName, $badge->name);
    }

    public function test_user_master_badge()
    {

        $this->seed();

        $targetBadgeName = "Master";

        $user = User::factory()->create();


        /** @var \App\Models\Badge */
        $targetBadge = $this->badgeRepo->allQuery()->where([
            "name" => $targetBadgeName
        ])->first();

        $this->addAchievementsToUser($user, $targetBadge->achievements);

        $achievements = $this->userService->getAllUnlockedAchievements($user);

        $badge =  $this->userService->getCurrentBadge($user);

        $this->assertCount($targetBadge->achievements, $achievements);
        $this->assertNotEmpty($badge);
        $this->assertEquals($targetBadgeName, $badge->name);
    }
}
