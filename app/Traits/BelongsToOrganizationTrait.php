<?php

namespace App\Traits;

use App\Organization;

trait BelongsToOrganizationTrait
{

    public function organization() {
        return $this->belongsTo(Organization::class);
    }

}
