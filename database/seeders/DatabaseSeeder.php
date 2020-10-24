<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Note;
use App\Models\Tag;
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
        define('TAG_COUNT', 50);

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

        $tags = Tag::factory()->count(TAG_COUNT)->create();


        foreach($notMe as $u){
            
            $u->notes()->saveMany(Note::factory()->count(rand(1, 50))->make());

            $notes = $u->notes()->get();

            foreach($notes as $nt){
                $tagCount = rand(0, TAG_COUNT / 10);
                for($i = 0; $i < $tagCount; $i++){
                    $tags->find(rand(1, TAG_COUNT))->notes()->attach($nt);
                }
            }
            
        }
    }
}
