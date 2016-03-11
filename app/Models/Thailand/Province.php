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

class Province extends Model
{
    protected $primaryKey = 'PROVINCE_ID';

    protected $table = "province";

    public function amphurs()
    {
        return $this->hasMany(Amphur::class, "PROVINCE_ID");
    }

    public function districts()
    {
        return $this->hasMany(District::class, "PROVINCE_ID");
    }

    public function projects()
    {
        return $this->hasMany(Project::class,"PROVINCE_ID");
    }

}