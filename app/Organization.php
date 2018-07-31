<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function users(){
        return $this->belongsToMany(User::class, 'organization_users');
    }

}
