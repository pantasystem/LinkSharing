<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class UserTest extends TestCase
{
    

    function testCreateUser(){

        $users = User::factory()->count(10)->create();


        assertTrue(count($users) == 10);
        


    }
}
