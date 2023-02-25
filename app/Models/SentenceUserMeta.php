<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SentenceUserMeta extends Model
{
    use HasFactory;

    protected $fillable = [
        'alphabet',
        'input',
        'correct'
    ];

    public function sentenceUsers()
    {
        return $this->belongsTo(SentenceUser::class);
    }
}
