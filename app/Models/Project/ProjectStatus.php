<?php
namespace App\Models\Project;

use Illuminate\Database\Eloquent\Model;

class ProjectStatus extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'project_status';


    protected $fillable = ['key', 'name', 'description'];


    public function projects()
    {
        return $this->hasMany(Project::class,'status_id');
    }
}