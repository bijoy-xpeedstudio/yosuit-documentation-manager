<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favourite extends Model
{
    use HasFactory;

    protected $table = "favourites";

    protected $fillable = [
        'model', 'model_id', 'user_id',
    ];


    public function userId()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
