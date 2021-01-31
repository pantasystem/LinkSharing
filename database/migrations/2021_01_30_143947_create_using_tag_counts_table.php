<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsingTagCountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $sql = "SELECT distinct tags.id as tag_id, tags.name as name, users.id as user_id, count(*) as count " .
        "FROM tags INNER JOIN tags_and_notes ON tags.id = tags_and_notes.tag_id " .
        "INNER JOIN notes ON tags_and_notes.note_id = notes.id " .
        "INNER JOIN users ON notes.author_id = users.id " .
        "GROUP BY users.id, tags.id;";
        DB::statement("DROP VIEW IF EXISTS using_tag_counts");
        DB::statement("CREATE VIEW using_tag_counts AS {$sql}");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW IF EXISTS using_tag_counts");
    }
}
