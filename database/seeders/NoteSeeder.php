<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Tag;
use App\Models\Note;

use App\Models\Summary;
/**
 * ノートのテスト用データを作成する
 * 作成パターン
 * 全ユーザーに対して100件ずつノートを作成する。
 * またユーザーのフォローフォロワー関係についてはこのSeederでは考慮しない。
 * SummaryはNoteSeederから作成することとする。
 * Summaryは本来Noteに属していてもおかしくない情報であるが、データと流れの都合上Noteと別で
 * NoteがSummaryの外部キーを持つNote：Summary=多：単になってしまっているが
 * イメージとしては１：１である。なのでSummaryは基本的にはIdで取得することはない。
 */
class NoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        User::all()->each(function(User $user){
            $summary = Summary::factory()->make();
            $summary = Summary::firstOrCreate([ 'url' => $summary->url ], $summary->toArray());
            Note::factory()->create([
                'summary_id' => $summary->id,
                'author_id' => $user->id,
            ]);
        });
    }
}
