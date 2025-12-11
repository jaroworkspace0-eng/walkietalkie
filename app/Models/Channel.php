<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Channel extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'client_id',
        'name',
        'category',
        'type'
    ];

    public function client(){
        return $this->belongsTo(Client::class);
    }
    public function employees(){
        return $this->hasMany(Employee::class);
    }
}
