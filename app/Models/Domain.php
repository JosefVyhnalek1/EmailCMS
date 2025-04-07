<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
    protected $fillable = ['name'];

    public $timestamps = false;

    public function emails()
    {
        return $this->hasMany(Email::class, 'domain_id');
    }
    public function forwardings()
    {
        return $this->hasMany(Forwarding::class, 'domain_id');
    }
}
