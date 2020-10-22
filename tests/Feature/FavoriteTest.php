<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use PHPUnit\Framework\Assert;
use App\Models\Note;
use DB;

class FavoriteTest extends TestCase
{

    use RefreshDatabase;
    
    private $targetNote = null;


    function setUp(): void
    {
        parent::setUp();


        $user = User::factory()->create();
        $this->targetNote = $user->notes()->save(Note::factory()->make());
    }

    function testFavorite()
    {

        $users = User::factory()->count(100)->create();

        foreach($users as $user){
            $this->targetNote->favorite($user);
        }


        $note = Note::withFavoriteCount()->find($this->targetNote->id);
        Assert::assertNotNull($note);

        Assert::assertEquals($note->favorite_count, 100);



        
        
    }
}
