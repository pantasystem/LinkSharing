<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Summary;

class SummaryTest extends TestCase
{
    use RefreshDatabase;
   
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

    public function testExecuteUpdateWordsが機能しているか()
    {
        $summary = Summary::factory()->create();
        $summary->description = "PHPでプログラミングをする。LaraveはPHPの欠点をラップしているのでとても使いやすい。概念も有名なフレームワークなどで使われているものが多いので習得しやすい。";
        $summary->save();
        $summary->executeUpdateWords();
        $rdbWords = $summary->words()->get();
        $this->assertNotEmpty($rdbWords->toArray());
    }

    public function testAggregateWordsが機能しているのか()
    {
        $summary = Summary::factory()->create();
        $summary->description = "PHPでプログラミングをする。LaraveはPHPの欠点をラップしているのでとても使いやすい。概念も有名なフレームワークなどで使われているものが多いので習得しやすい。PHPはComposerを使うととてもいいぞいいぞ。PHPは使い方次第で楽しいし地獄にもなる";
        $summary->save();
        $summary->executeUpdateWords();
        $aggregatedWords = $summary->aggregateWords()->get();

        echo $aggregatedWords;
        $this->assertNotEquals(0,$aggregatedWords->count());
        $this->assertEquals("PHP", $aggregatedWords[0]->word);
    }
}
