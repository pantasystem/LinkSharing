<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\SummaryLoader;
use App\Models\Sammary;
use PHPUnit\Framework\Assert;
use App\Models\Note;


class SummaryLoaderTest extends TestCase
{
    function testGetTwitterSummary()
    {
        $url = "https://twitter.com/Kotlin_kawaii/status/1319599176154398720";
        //$summary = new SummaryLoader();

        $loader = new SummaryLoader();
        $summary = $loader->getSummary($url);
        dd($summary);
        Assert::assertNotEmpty($summary['title']);
        //Assert::assertNotNull($summary);
    }
}
