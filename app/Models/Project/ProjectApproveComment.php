<?php
namespace App\Models\Project;

use App\Models\Faculty;
use App\Models\Thailand\Amphur;
use App\Models\Thailand\District;
use App\Models\Thailand\Province;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class ProjectApproveComment extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'project_approve_comments';


    public function project(){
        return $this->belongsTo(Project::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

}