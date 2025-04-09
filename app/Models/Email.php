<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    protected $fillable = [
        'email',
        'password',
        'domain_id',
    ];

    public $timestamps = false;


    public function domains()
    {
        return $this->belongsTo(Domain::class, 'domain_id');
    }
    public function forwardings()
    {
        return $this->hasOne(Forwarding::class, 'source', 'email');
    }

    public function senderBccs()
    {
        return $this->hasOne(SenderBcc::class, 'source', 'email');
    }
}
