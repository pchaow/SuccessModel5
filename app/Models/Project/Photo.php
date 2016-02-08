<?php
namespace App\Models\Project;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'photos';


    protected $fillable = ['description'];

}