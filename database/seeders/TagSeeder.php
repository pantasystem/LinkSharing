<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Note;
use App\Models\Tag;

/**
 * データベース中に存在するノートの件数nに対し
 * タグの件数tで以下の条件の範囲内でランダムにノートにタグ付を行う
 * ノートに対してのタグ数k
 * 0 <= k < 10 かつ k < t
 */
class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tag::factory()->count(50)->create();


        Note::all()->each(function(Note $note){
            $count = rand(0, 10);
            $tags_ids = Tag::inRandomOrder()->take($count)->pluck('id')->toArray();
            $note->tags()->sync($tags_ids);
        });
    }
}
