<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\LessonUser;
use Tests\TestCase;
use App\Models\User;
use App\Repositories\CommentAchievementRepository;
use App\Repositories\CommentRepository;
use App\Repositories\LessonRepository;
use App\Services\UserService;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CommentAchievementTest extends TestCase
{
    use DatabaseTransactions;

    private CommentRepository $commentRepo;
    private CommentAchievementRepository $commentAchievementRepo;
    private UserService $userService;


    public function setUp(): void
    {
        parent::setUp();

        $this->commentRepo = app(CommentRepository::class);
        $this->commentAchievementRepo = app(CommentAchievementRepository::class);
        $this->userService = app(UserService::class);
    }


    private function test_comments_achievement(string $name)
    {
        $user = User::factory()->create();

        /** @var \App\Models\CommentAchievement */
        $testAchievement = $this->commentAchievementRepo->allQuery()
            ->where([
                "name" => $name
            ])->first();


        for ($i = 0; $i < $testAchievement->comments; $i++) {
            Comment::create([
                "body" => "Testing comment",
                "user_id" => $user->id,
            ]);
        }


        $achievements = $this->userService->getUnlockedCommentsAchievements($user);

        /** @var \App\Models\CommentAchievement */
        $achievement =  $this->userService->getUnlockedLastCommentsAchievement($user);

        $expectedAchievements = UserService::COMMENTS_TO_ACHIEVEMENTS($testAchievement->comments);

        $this->assertCount(count($expectedAchievements), $achievements);
        $this->assertNotEmpty($achievement);
        $this->assertEquals($name, $achievement->name);
    }


    public function test_first_comment_achievement()
    {
        $this->seed();

        $this->test_comments_achievement("First Comment Written");
    }

    public function test_3_comments_achievement()
    {
        $this->seed();

        $this->test_comments_achievement("3 Comments Written");
    }

    public function test_5_comments_achievement()
    {
        $this->seed();

        $this->test_comments_achievement("5 Comments Written");
    }

    public function test_10_comments_achievement()
    {
        $this->seed();

        $this->test_comments_achievement("10 Comments Written");
    }


    public function test_20_comments_achievement()
    {
        $this->seed();

        $this->test_comments_achievement("20 Comments Written");
    }
}
