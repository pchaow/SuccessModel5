<?php namespace App\Models\Posts;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'post_photos';

    public function photos()
    {
        return $this->hasMany(Photo::class, 'post_id');
    }

    public function status()
    {
        return $this->belongsTo(PostStatus::class, 'status_id');
    }


}