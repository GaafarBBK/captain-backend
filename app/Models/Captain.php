<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Captain extends Model
{
    use HasFactory;

    protected $fillable = [
        'experience',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function subscribers(){
        return $this->hasMany(CaptainSubscribers::class);
    }

    public function subscription(){
        return $this->hasMany(CaptainSubscription::class);
    }
   
}
