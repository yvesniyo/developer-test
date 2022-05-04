<?php

namespace Tests\Unit;

use App\Repositories\BadgeRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BadgeRepositoryTest extends TestCase
{
    use  DatabaseTransactions;

    private BadgeRepository $badgeRepository;

    public function setUp(): void
    {
        parent::setUp();
        $this->badgeRepository = app(BadgeRepository::class);
    }


    public function test_create_badge()
    {


        $badge = $this->badgeRepository->create([
            "name" => "Another",
            "achievements" => 15
        ]);


        $this->assertEquals("Another", $badge->name);
        $this->assertEquals(15, $badge->achievements);
    }


    public function test_create_unique_badge()
    {


        try {
            $this->badgeRepository->create([
                "name" => "Random",
                "achievements" => 100
            ]);
            $this->badgeRepository->create([
                "name" => "Random",
                "achievements" => 100
            ]);
        } catch (\Illuminate\Database\QueryException $e) {

            $errorCode = $e->errorInfo[1];

            $this->assertEquals(1062, $errorCode, "Failed to create unique badge");
        }
    }
}
