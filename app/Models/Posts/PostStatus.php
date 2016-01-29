<?php namespace App\Models\Posts;

use Illuminate\Database\Eloquent\Model;

class PostStatus extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'post_status';


    protected $fillable = ['key', 'description'];

    public function posts()
    {
        return $this->hasMany(Post::class, 'status_id');
    }

}