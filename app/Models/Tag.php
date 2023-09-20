<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;
    // public function documents()
    // {
    //     return $this->morphToMany('App\Models\Document', 'taggables');
    // }

    // public function videos()
    // {
    //     return $this->morphToMany('App\Models\Folder', 'taggables');
    // }
    public function taggable()
    {
        return $this->morphTo();
    }
    public function addedBy()
    {
        return $this->belongsTo(User::class, 'added_by', 'id');
    }
}
