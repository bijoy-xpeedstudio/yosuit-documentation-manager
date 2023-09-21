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
    // public function tags()
    // {
    //     return $this->morphToMany(Tag::class, 'taggable');
    // }
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }
    public function addedBy()
    {
        return $this->belongsTo(User::class, 'added_by', 'id');
    }

    public function documents()
    {
        return $this->hasMany(Document::class,  'cid', 'id');
    }
}
