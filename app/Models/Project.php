<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'projects';


    protected $fillable = ['name_th', 'name_en', 'description_th', 'description_en', 'location', 'lat', 'long'];

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
        return $this->belongsToMany(User::class, "project_user", "user_id", "project_id");
    }
}