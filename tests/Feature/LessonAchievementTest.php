<?php

namespace Tests\Feature;

use App\Models\Lesson;
use App\Models\LessonUser;
use Tests\TestCase;
use App\Models\User;
use App\Repositories\LessonAchievementRepository;
use App\Repositories\LessonRepository;
use App\Services\UserService;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LessonAchievementTest extends TestCase
{
    use DatabaseTransactions;

    private LessonRepository $lessonRepo;
    private UserService $userService;
    private LessonAchievementRepository $lessonAchievementRepo;


    public function setUp(): void
    {
        parent::setUp();

        $this->lessonRepo = app(LessonRepository::class);
        $this->userService = app(UserService::class);
        $this->lessonAchievementRepo = app(LessonAchievementRepository::class);
    }



    private function addWatchesToUser(User $user, int $watches = 1)
    {

        Lesson::factory()->count(100)->create();

        $lessons = $this->lessonRepo->allQuery()->get();


        foreach ($lessons as $key => $lesson) {

            if ($key == $watches) {
                break;
            }

            LessonUser::create([
                "lesson_id" => $lesson->id,
                "user_id" => $user->id,
                "watched" => true,
            ]);
        }
    }

    private function test_lessson_watched_achievement(string $name)
    {

        /** @var \App\Models\LessonAchievement */
        $testAchievement = $this->lessonAchievementRepo->allQuery()
            ->where([
                "name" => $name
            ])->first();

        $user = User::factory()->create();

        $this->addWatchesToUser($user, $testAchievement->watches);

        $achievements = $this->userService->getUnlockedLessonsAchievements($user);

        $achievement =  $this->userService->getUnlockedLastLessonsAchievement($user);

        $this->assertNotEmpty($achievement);

        $achievement_for_watches = UserService::LESSON_WATCHED_TO_ACHIEVEMENTS($testAchievement->watches);
        $this->assertCount(count($achievement_for_watches), $achievements);

        $this->assertEquals($testAchievement->name, $achievement->name);
    }


    public function test_first_lessson_watched_achievement()
    {
        $this->seed();


        $this->test_lessson_watched_achievement("First Lesson Watched");
    }

    public function test_5_lessson_watched_achievement()
    {
        $this->seed();
        $this->test_lessson_watched_achievement("5 Lessons Watched");
    }


    public function test_10_lessson_watched_achievement()
    {
        $this->seed();

        $this->test_lessson_watched_achievement("10 Lessons Watched");
    }

    public function test_25_lessson_watched_achievement()
    {
        $this->seed();

        $this->test_lessson_watched_achievement("25 Lessons Watched");
    }

    public function test_50_lessson_watched_achievement()
    {
        $this->seed();

        $this->test_lessson_watched_achievement("50 Lessons Watched");
    }
}
