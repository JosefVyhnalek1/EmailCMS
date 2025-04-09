<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Forwarding extends Model
{
    protected $fillable = [
        'source',
        'destination',
        'domain_id'
    ];

    public $timestamps = false;


    public function domains()
    {
        return $this->belongsTo(Domain::class, 'domain_id');
    }

    public function emails()
    {
        return $this->belongsTo(Email::class, 'source', 'email');
    }
}
