<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $hidden = ['updated_at'];

    public function readings()
    {
        return $this->hasMany(Reading::class);
    }
}
