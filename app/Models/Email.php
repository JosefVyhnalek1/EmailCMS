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
    public function forwardings()
    {
        return $this->hasOne(Forwarding::class, 'source', 'email');
    }
}
