<?php
namespace App\Models;

/**
 * Created by PhpStorm.
 * UserRequest: chaow
 * Date: 4/6/2015
 * Time: 12:59 PM
 */

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Faculty extends Model
{

    use SoftDeletes;

    protected $fillable = ['name_en', 'name_th'];


    public function projects()
    {
        return $this->hasMany(Project::class);
    }

}