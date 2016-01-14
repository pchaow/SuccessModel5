<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProvinceAmphurDistrictToProjects extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn("lat");
            $table->dropColumn("long");

            $table->integer("province_id");
            $table->integer("amphur_id");
            $table->integer("district_id");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->integer("lat");
            $table->integer("long");

            $table->dropColumn("province_id");
            $table->dropColumn("amphur_id");
            $table->dropColumn("district_id");
        });
    }
}


