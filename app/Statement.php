<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Statement extends Model
{
    use Traits\BelongsToOrganizationTrait;

    public function fullPath(){
        return storage_path('app/'. $this->path);
    }

}
