<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sentence extends Model
{
    use HasFactory;

    protected $fillable = ['sentence', 'sentence_ko'];
    protected $with = ['category'];

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('id', 'input', 'length', 'correct', 'wrong', 'perfect', 'started_at', 'finished_at', 'wpm', 'created_at', 'updated_at');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['category_id'] ?? false, fn($query, $category) =>
            $query->where('category_id', $category)
        );

        $query->when($filters['limit'] ?? false, fn($query, $limit) =>
            $query->limit($limit)
        );
    }
}
