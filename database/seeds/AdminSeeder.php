<?php
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Role;

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
        $user->username="admin";
        $user->password =  \Hash::make("admin");
        $user->save();

        $user->roles()->save(Role::where("key","=","admin")->first());


    }

}
