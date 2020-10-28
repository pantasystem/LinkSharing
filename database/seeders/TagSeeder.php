<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

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
        //
    }
}
