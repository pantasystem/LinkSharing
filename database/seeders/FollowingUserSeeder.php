<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

/**
 * ユーザーのフォロー関係を保持するFollowingUserSeeder
 * 各ユーザーは自分を除くDB中のユーザー全てをフォローするものとする。
 * つまりユーザーが全部で100件だとすれば9900件のレコードが作成されることとなる。
 * またNotificationの作成処理はしないこととする。
 */
class FollowingUserSeeder extends Seeder
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
