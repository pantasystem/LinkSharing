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

    private $targetUser = null;
    private $followings = null;
    private $followers = null;

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

        // 非相互のフォロワー
        $followers = User::factory()->count(10)->create();
        $this->followers = $followers;
        foreach($followers as $follower){
            $follower->followings()->attach($this->targetUser);
        }


    }

    function testTimeline(){

        
        Assert::assertEquals(100, count($this->targetUser->followings()->get()));

        foreach($this->targetUser->followings()->get() as $follow){
            Assert::assertEquals(10, count($follow->notes()->get()));
        }
        $count = count($this->targetUser->timeline()->get());
        Assert::assertEquals(1000, $count);
    }

    /**
     * 他ユーザーのタイムラインが混信しないことを確認する
     */
    function testMixedOtherUsersTimeline(){

        $otherUsers = User::factory()->count(100)->create();
        foreach($otherUsers as $other){
            $other->notes()->saveMany(Note::factory()->count(4)->make());
        }

        $count = count($this->targetUser->timeline()->get());
        Assert::assertEquals(1000, $count);

        
    }

    function testNotMixedOneSidedNotFollowersTimeline(){
        $otherUsers = $this->followers;
        foreach($otherUsers as $other){
            $other->notes()->saveMany(Note::factory()->count(4)->make());
        }

        $count = count($this->targetUser->timeline()->get());
        Assert::assertEquals(1000, $count);
    }
}
