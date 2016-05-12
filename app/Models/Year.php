<?php namespace App\Models;

use App\Models\Project\Project;
use Illuminate\Database\Eloquent\Model;

class Year extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'project_year';

    protected $fillable = ['year'];

    public function projects()
    {
        return $this->hasMany(Project::class,'year','year');
    }

}