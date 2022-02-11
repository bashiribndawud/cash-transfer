<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    use HasFactory;

    protected $fillable = [
        'userId', 
        'sender_id', 
        'receiver_id', 
        'usd',
        'ngn',
        'eur',
        'status'
    
    ];

    public function sender(){
        return $this->belongsTo(User::class, 'sender_id', 'id');
    }

    public function reciever(){
        return $this->belongsTo(User::class, 'receiver_id', 'id');
    }
}
