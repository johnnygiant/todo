<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Task extends Model
{
    protected $fillable = [
        'title', 'body', 'completed', 'user_id'
    ];

    public function user()
    {
      return $this->belongsTo('App\User');
    }
}
