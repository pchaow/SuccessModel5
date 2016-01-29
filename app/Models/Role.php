<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'roles';


    protected $fillable = ['key', 'name', 'description'];

    public function users()
    {
        return $this->belongsToMany(User::class, "role_user");
    }

}