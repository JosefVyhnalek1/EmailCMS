<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    //

    public function domains()
    {
        return $this->belongsTo(Domain::class, 'domain_id');
    }
}
