<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'firstname', 'lastname', 'email', 'username',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function roles()
    {
        return $this->belongsToMany(Role::class, "role_user");
    }

    public function faculty()
    {
        return $this->belongsTo(Faculty::class, "faculty_id");
    }

    public function is($roleName)
    {
        foreach ($this->roles()->get() as $role)
        {
            if ($role->key == $roleName)
            {
                return true;
            }
        }

        return false;
    }
}
