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

    private $summaries = null;

    function setUp(): void{
        parent::setUp();

        $this->summaries = Summary::factory()->count(50)->create();

        User::factory()->count(100)->create();
    }
    

    public function testCreateNote(){

        $targetUser = User::first();

        foreach($this->summaries as $summary){
            $note = Note::factory()->count(10)->create([
                'author_id' => $targetUser->id,
                'summary_id' => $summary->id
            ]);
        }

    
        Assert::assertEquals(count($targetUser->notes()->get()), 500);
    }

    public function testFindUsersNotes(){
        $targetUser = User::first();

        Assert::assertNotNull($targetUser);

        $summary = Summary::factory()->create();

        $targetUser->notes()->saveMany(Note::factory()->count(100)->make(['summary_id' => $summary->id]));
        Assert::assertEquals(count($targetUser->notes()->get()), 100);

    }
}
