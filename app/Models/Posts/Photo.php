<?php namespace App\Models\Posts;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'post_photos';


    protected $fillable = ['description'];

}