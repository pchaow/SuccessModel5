<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name_th');
            $table->string('name_en');
            $table->text('description_th');
            $table->text('description_en');
            $table->integer('faculty_id');
            $table->integer('status_id');
            $table->string('cover_file');
            $table->string("location");
            $table->text("geojson");
            $table->integer("province_id");
            $table->integer("amphur_id");
            $table->integer("district_id");
            $table->integer('create_by');
            $table->softDeletes();
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

        Schema::drop('projects');

    }
}
