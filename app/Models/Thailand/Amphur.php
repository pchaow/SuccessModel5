<?php
namespace App\Models\Thailand;

/**
 * Created by PhpStorm.
 * UserRequest: chaow
 * Date: 4/6/2015
 * Time: 12:59 PM
 */

use App\Models\Project\Project;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Amphur extends Model
{
    protected $primaryKey = 'AMPHUR_ID';


    protected $table = "amphur";

    public function districts()
    {
        return $this->hasMany(District::class, "AMPHUR_ID");
    }

    public function projects(){
        return $this->hasMany(Project::class,"amphur_id");
    }


}