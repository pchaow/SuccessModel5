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


    protected $fillable = ['name_th', 'name_en', 'description_th', 'description_en'];

    public function faculty()
    {
        return $this->belongsTo("App\\Models\\Faculty", "faculty_id");
    }

    public function status()
    {
        return $this->belongsTo("App\\Models\\ProjectStatus", "status_id");
    }

}