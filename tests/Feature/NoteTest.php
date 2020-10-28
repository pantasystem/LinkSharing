<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use PHPUnit\Framework\Assert;
use App\Models\Note;
use App\Models\Summary;

class NoteTest extends TestCase
{
    use RefreshDatabase;

    

    function setUp(): void{
        parent::setUp();

        Summary::factory()->count(50)->create();
    }
    

    public function testCreateNote(){

        $targetUser = User::first();
        
        $targetUser->notes()->saveMany(Note::factory()->count(100)->make());

        Assert::assertEquals(count($targetUser->notes()->get()), 100);
    }

    public function testFindUsersNotes(){
        $targetUser = User::first();

        Assert::assertNotNull($targetUser);

        $targetUser->notes()->saveMany(Note::factory()->count(100)->make());
        Assert::assertEquals(count($targetUser->notes()->get()), 100);


        $otherUsers = User::where('id', '>', $targetUser->id)->get();

        foreach($otherUsers as $other){
            $other->notes()->saveMany(Note::factory()->count(10)->make());

        }

        Assert::assertEquals(count($targetUser->notes()->get()), 100);

    }
}
