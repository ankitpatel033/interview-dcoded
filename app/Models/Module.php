<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function materials()
    {
        return $this->hasMany(ModuleMaterial::class);
    }

    public function questions()
    {
        return $this->hasMany(ModuleQuestion::class)->with('options');
    }
}
