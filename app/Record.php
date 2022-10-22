<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    //
    protected $fillable = ['content', 'image_path'];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
