<?php
namespace App\Models\Project;

use App\Models\Faculty;
use App\Models\Thailand\Amphur;
use App\Models\Thailand\District;
use App\Models\Thailand\Province;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'projects';


    protected $fillable = ['name_th', 'name_en', 'description_th', 'description_en', 'location', 'amphur_id', 'province_id', 'district_id'];

    public function faculty()
    {
        return $this->belongsTo(Faculty::class, "faculty_id");
    }

    public function status()
    {
        return $this->belongsTo(ProjectStatus::class, "status_id");
    }

    public function photos()
    {
        return $this->hasMany(Photo::class, "project_id");
    }

    public function youtubes()
    {
        return $this->hasMany(Youtube::class, "project_id");
    }

    public function users()
    {
        return $this->belongsToMany(User::class, "project_user");
    }

    public function province()
    {
        return $this->belongsTo(Province::class, "province_id");
    }

    public function amphur()
    {
        return $this->belongsTo(Amphur::class, "amphur_id");
    }

    public function district()
    {
        return $this->belongsTo(District::class, "district_id");
    }

    public function createBy()
    {
        return $this->belongsTo(User::class, "create_by");
    }

}