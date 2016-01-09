<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Youtube extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'youtubes';


    protected $fillable = ['url'];

}