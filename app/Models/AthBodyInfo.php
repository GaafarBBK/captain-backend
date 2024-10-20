<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AthBodyInfo extends Model
{
    protected $fillable = ['height', 'user_id', 'weight','gender','age','ath_lvl','ath_goal','ath_body'];
    use HasFactory;

    public function user(){
        return $this->belongsTo(User::class);
    }
}
