<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Summary;

class SummaryTest extends TestCase
{
   
    public function testCreateSummary()
    {
        Summary::factory()->count(100)->create();
    }

    public function testCreateAndFindSummary()
    {
        $summaries = Summary::factory()->count(10)->make();

        foreach($summaries as $summary){
            $saved = $summary->save();

            $this->assertNotNull($saved);
        }


    }

    public function testGetWordsが動作しているか()
    {
        $summary = new Summary([]);
        $summary->description = "Fateはいいぞ。正月はFateを見て過ごすことにした。PHPはLaravelを使えば楽しいな。寝耳に水。すももももももものもの";
        $result = $summary->getWords();
        echo "getWordsテスト";
        var_dump($result);
        $this->assertNotEmpty($result);

    }
}
