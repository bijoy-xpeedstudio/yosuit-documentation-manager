<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fevourite extends Model
{
    use HasFactory;
    protected $fillable = [
        'model', 'model_id', 'user_id',
    ];


    public function userId()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function modelId()
    {
        dd($this->attributes);
        return $this->belongsTo(Document::class, 'model_id', 'id');


        if ($this->model == 'document') {
            $data = $this->belongsTo(Document::class, 'id', 'model_id');
        } else if ($this->model == 'folder') {
            $data = $this->belongsTo(Folder::class, 'id', 'model_id');
        }
        return $data;
    }
}
