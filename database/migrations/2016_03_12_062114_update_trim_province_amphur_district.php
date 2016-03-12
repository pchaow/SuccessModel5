<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTrimProvinceAmphurDistrict extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //UPDATE amphur set AMPHUR_NAME = TRIM(AMPHUR_NAME);
        DB::update("UPDATE province set PROVINCE_NAME = TRIM(PROVINCE_NAME)");
        DB::update("UPDATE amphur set AMPHUR_NAME = TRIM(AMPHUR_NAME)");
        DB::update("UPDATE district set district_name = TRIM(district_name)");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
