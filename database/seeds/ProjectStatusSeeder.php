<?php
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Faculty;

class ProjectStatusSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */


	public function run()
	{

        $statuses = [
            ["draft","Draft","Project is in draft or not submit"],
            ["faculty","Faculty Review Pending","Project is in faculty reviewing process"],
            ["university","University Review Pending","Project is in university reviewing process"],
            ["published","Published","Project has been published to public"]
        ];

        foreach ($statuses as $s) {
            $status = new \App\Models\ProjectStatus();
            $status->key = $s[0];
            $status->name = $s[1];
            $status->description = $s[2];
            $status->save();
        }
    }

}
