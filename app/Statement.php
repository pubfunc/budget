<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Statement extends Model
{

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function fullPath(){
        return storage_path('app/'. $this->path);
    }


}
