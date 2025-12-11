<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'first_name', 
        'last_name', 
        'email',
        'phone',
        'occupation',
        'client_id',
        'channel_id'
    ];

    public function client() {
        return $this->belongsTo(Client::class);
    }


    public function channel() {
        return $this->belongsTo(Channel::class);
    }
}
