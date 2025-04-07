<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Forwarding extends Model
{
    //

    public function emails()
    {
        return $this->belongsTo(Email::class, 'source', 'email');
    }
}
