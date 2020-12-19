<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Note;
use App\Models\Tag;
use Illuminate\Support\Facades\Hash;
use App\Models\Summary;
use App\Models\Comment;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
       $this->call([
           UserSeeder::class,
           NoteSeeder::class,
           TagSeeder::class,
           FavoriteSeeder::class,
           FollowingUserSeeder::class,
           CommentSeeder::class
       ]);
    }
}
