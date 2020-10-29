<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Note;

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
        User::whereRaw('mod(id, 2) <> 0')->each(function(User $user){
            $noteIds = Note::where('author_id', '<>', $user->id)->pluck('id')->toArray();
            $user->favoritedNotes()->sync($noteIds);
        });
    }
}
