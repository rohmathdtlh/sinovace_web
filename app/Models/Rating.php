<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $fillable = ['lapor_id', 'user_id', 'admin_id', 'rating',];
    
    public function lapor()
    {
        return $this->belongsTo(Lapor::class)->withDefault(); // biar nggak error kalau null
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}