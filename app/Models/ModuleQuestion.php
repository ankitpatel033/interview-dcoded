<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModuleQuestion extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function options() {
        return $this->hasMany(QuestionOption::class, 'question_id', 'id');
    }
}
