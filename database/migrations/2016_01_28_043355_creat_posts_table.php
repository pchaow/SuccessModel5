<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_status', function (Blueprint $t) {
            $t->increments('id');
            $t->string('key');
            $t->text('description');
            $t->timestamps();
        });

        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('content');
            $table->integer('status_id');
            $table->string('cover_file');
            $table->integer('create_by');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('post_photos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('filename');
            $table->text('description')->nullable();;
            $table->integer('post_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('post_photos');
        Schema::drop('posts');
        Schema::drop('post_status');
    }
}
