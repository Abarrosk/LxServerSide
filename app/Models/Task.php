<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    // Nao vai funcionar pois a sintaxe está errada
    function scopeTaskByUser($query, $user){
    $query->where('id', $user)->get();
   }

    const STATUS_COMPLETED = 1;
   const STATUS_NOTDONE = 0;
}
