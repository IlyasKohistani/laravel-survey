<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'question_id',
        'answer_id',
        'parent_id',
        'category_id',
    ];

    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }
}
