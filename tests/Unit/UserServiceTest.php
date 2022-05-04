<?php

namespace Tests\Unit;

use App\Models\Badge;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\UserService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    use DatabaseTransactions;

    private UserService $userService;
    private UserRepository $userRepository;

    public function setUp(): void
    {
        parent::setUp();
        $this->userService = app(UserService::class);
        $this->userRepository = app(UserRepository::class);
    }


    public function test_get_user_current_badge()
    {
        $this->seed();

        $user = User::factory()->makeOne();
        $password = $user->password;
        $user = $user->toArray();
        $user["password"] = $password;

        $user = $this->userRepository->create($user);

        $badge =  $this->userService->getCurrentBadge($user);
        $this->assertInstanceOf(Badge::class, $badge);
        $this->assertEquals("Beginner", $badge->name);
    }
}
