<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use PHPUnit\Framework\Assert;
class UserTest extends TestCase
{

    use RefreshDatabase;
    

    function testCreateUser(){

        $users = User::factory()->count(10)->create();


        Assert::assertTrue(count($users) == 10);
        


    }

    function testFindById(){
        $users = User::factory()->count(10)->create();
        print(gettype($users));

        $user = $users->get(3);

        Assert::assertEquals(10, count($users));
        Assert::assertNotNull($user);

        var_dump(gettype($user));

        $findById = User::where('id', '=', $user->id)->first();

        //var_dump($user);
        Assert::assertNotNull($findById);
        Assert::assertEquals($user->id, $findById->id);
        
    }

    function testFindByEmail(){
        $users = User::factory()->count(10)->create();
        print(gettype($users));

        $user = $users->get(3);

        $found = User::where('email', '=', $user->email)->first();

        Assert::assertNotNull($found);
        Assert::assertEquals($user->id, $found->id);
    }
}
