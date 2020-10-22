<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Note;
use Illuminate\Support\Facades\Hash;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $me = User::create([
            'email' => 'panta@test.jp',
            'password' => Hash::make('testtest'),
            'user_name' => 'Panta'
        ]);

        User::factory()->count(500)->create();

        $followUsers = User::whereBetween('id', [100, 200])->get();

        $followerUsers = User::whereBetween('id', [120, 500])->get();

        foreach($followUsers as $u){
            $me->follow($u);
        }

        foreach($followerUsers as $u){
            $u->follow($me);
        }

        $notMe = User::where('id', '<>', $me->id)->get();

        foreach($notMe as $u){
            $notes = Note::factory()->count(100)->make();
            $u->notes()->saveMany($notes);
        }
    }
}
