<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClubMatch extends Model
{
    use HasFactory;
    
    protected $guarded = ['id'];

    public function club_home()
    {
        return $this->belongsTo(Club::class, 'club_id_1');
    }

    public function club_away()
    {
        return $this->belongsTo(Club::class, 'club_id_2');
    }
}
