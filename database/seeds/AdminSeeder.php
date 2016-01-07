<?php
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Faculty;

class AdminSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */


	public function run()
	{
        DB::table('users')->delete();


        $user = new \App\Models\User();
        $user->email="admin@success.local";
        $user->password =  \Hash::make("admin");
        $user->save();

    }

}
