<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use PHPUnit\Framework\Assert;
use App\Models\User;
use App\Models\Note;

class TimelineTest extends TestCase
{
    
    use RefreshDatabase;

    /*private $targetUser = null;
    private $followings = null;

    function setUp(): void{
        parent::setUp();



        $this->targetUser = User::factory()->create();

        // フォローしているユーザーを作成する
        $followingUsers = User::factory()->count(100)->create();

        foreach($followingUsers as $follow){
            $this->targetUser->followings()->attach($follow);

        }


        $this->followings = $followingUsers;

        // フォローしているユーザーにNoteを１０個ずつ持たせる
        foreach($followingUsers as $follow){
            $follow->notes()->saveMany(Note::factory()->count(10)->make());
        }

    }
*/
    function testTimeline(){

        $targetUser = User::factory()->create();

        // フォローしているユーザーを作成する
        $followingUsers = User::factory()->count(100)->create();

        foreach($followingUsers as $follow){
            $targetUser->followings()->attach($follow);

        }


        $followings = $followingUsers;

        // フォローしているユーザーにNoteを１０個ずつ持たせる
        foreach($followingUsers as $follow){
            $follow->notes()->saveMany(Note::factory()->count(10)->make());
        }

        Assert::assertEquals(100, count($targetUser->followings()->get()));

        foreach($targetUser->followings()->get() as $follow){
            Assert::assertEquals(10, count($follow->notes()->get()));
        }
        $count = count($targetUser->timeline()->get());
        Assert::assertEquals(1000, $count);
    }
}
