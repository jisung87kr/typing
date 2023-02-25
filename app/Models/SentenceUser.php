<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class SentenceUser extends Pivot
{
    use HasFactory;
    protected $fillable = [
        'input',
        'length',
        'correct',
        'wrong',
        'perfect',
        'started_at',
        'finished_at',
        'wpm',
        'difftime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function sentence()
    {
        return $this->belongsTo(Sentence::class, 'sentence_id', 'id');
    }

    public function sentenceUserMetas()
    {
        return $this->hasMany(SentenceUserMeta::class, 'sentence_user_id', 'id');
    }
}
