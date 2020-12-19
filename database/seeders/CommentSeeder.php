<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Note;
use App\Models\Comment;
use App\Events\Replied;
use App\Models\User;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Note::each(function(Note $note){
            $range = rand(0, 5);
            User::inRandomOrder()->take($range)->get()->each(function(User $user) use ($note){
                $comment = Comment::factory()->make();
                $comment->author()->associate($user);
                $note->comments()->save($comment);
            });
        });
    }
}
