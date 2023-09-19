<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;
    protected $table = 'documents';

    protected $fillable = [
        'cid', 'title', 'tags', 'json', 'type', 'added_by'
    ];

    public function addedBy()
    {
        return $this->belongsTo(User::class, 'added_by', 'id');
    }
}
