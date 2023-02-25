<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sentence extends Model
{
    use HasFactory;

    protected $fillable = ['sentence', 'sentence_ko'];

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('id', 'input', 'length', 'correct', 'wrong', 'perfect', 'started_at', 'finished_at', 'wpm', 'created_at', 'updated_at');
    }
}
