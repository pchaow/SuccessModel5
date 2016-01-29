<?php
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Faculty;

class PostStatusSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */


    public function run()
    {
        DB::table('post_status')->delete();

        $statuses = [
            ["draft", "Post is in draft or not submit"],
            ["published", "Post has been published to public"]
        ];

        foreach ($statuses as $s) {
            $status = new \App\Models\Posts\PostStatus();
            $status->key = $s[0];
            $status->description = $s[1];
            $status->save();
        }
    }

}
