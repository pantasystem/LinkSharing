<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

/**
 * 奇数idのユーザーは自分を除く全てのユーザーの投稿に対してFavoriteする。
 * また同時にNotificationも作成する。
 */
class FavoriteSeeder extends Seeder
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
