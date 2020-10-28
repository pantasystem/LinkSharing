<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

/**
 * ユーザーを作成するSeeder
 * ユーザーを作成する件数は100件作成することとする。
 * またフォローフォロワー関係についてはこのSeederは一切責務を負わない。
 */
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $me = User::create([
            'email' => 'panta@test.jp',
            'password' => Hash::make('testtest'),
            'user_name' => 'Panta'
        ]);

        User::factory()->count(500)->create();

    }
}
