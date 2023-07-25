<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function matches_home()
    {
        return $this->hasMany(ClubMatch::class, 'club_id_1');
    }

    public function matches_away()
    {
        return $this->hasMany(ClubMatch::class, 'club_id_2');
    }
}
