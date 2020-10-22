<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use PHPUnit\Framework\Assert;


class FollowingUser extends TestCase
{
    use RefreshDatabase;

    function setUp(){
        parent::setUp();
        
        User::factory()->count(30)->create();
    }

    function testFollowingUser(){

        $followUsers = User::whereBetween('id', [10, 30]);

        $followingCount = count($followUsers);

        $target = User::find(1);

        foreach($followUsers as $followUser){
            $target->followings()->attach($followUser);
        }

        Assert::assertEquals($followingCount, count($target->followings()->get()));

        foreach($followUsers as $exceptFollowUser){
            Assert::assertNotNull($target->followings()->find($exceptFollowUser->id));
        }
    }

    function testFollowersUser(){
        $followersUsers = User::whereBetween('id', [10, 30]);
        $target = User::find(1);

        $followersCount = count($followersUsers);

        foreach($followersUsers as $follower){
            $follower->followings()->attach($target);
        }

        Assert::assertEquals($followersCount, count($target->followers()->get()));

        foreach($followUsers as $exceptFollower){
            Assert::assertNotNull($target->followers()->find($exceptFollower->id));
        }
    }

    function testMixedFollowersFollowings(){
        testFollowersUser();
        testFollowingUser();

        $user = User::find(1);
        Assert::assertNotNull($user->followings()->first()->followings()->find(1));
    }
}
