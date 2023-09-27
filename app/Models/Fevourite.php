<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fevourite extends Model
{
    use HasFactory;
    protected $fillable = [
        'model', 'model_id', 'user_id'
    ];


    public function userId()
    {
        return $this->belongsTo(User::class, 'id', 'user_id');
    }
}
