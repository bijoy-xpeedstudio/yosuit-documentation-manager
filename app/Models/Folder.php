<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    use HasFactory;

    public function subFolder(){
        return $this->hasMany(Folder::class, 'parent_id', 'id');
        
    }
}
