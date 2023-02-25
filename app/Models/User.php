<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected static function booted()
    {
        static::addGlobalScope('user', function (Builder $builder) {
            $builder->when(empty($builder->getQuery()->columns), fn ($query) =>
                $query->select('*')
            );
            $builder->addSelect(DB::raw("(SELECT MAX(wpm) FROM sentence_user WHERE user_id = users.id) AS max_wpm"));
            $builder->addSelect(DB::raw("(SELECT AVG(wpm) FROM sentence_user WHERE user_id = users.id) AS avg_wpm"));
            $builder->addSelect(DB::raw("(SELECT COUNT(*) FROM sentence_user WHERE user_id = users.id) AS sentence_cnt"));
            $builder->addSelect(DB::raw("(SELECT SUM(usetime) FROM sentence_user WHERE user_id = users.id) AS used_time"));
        });
    }

    public function sentences()
    {
        return $this->belongsToMany(Sentence::class)->withPivot('id', 'input', 'length', 'correct', 'wrong', 'perfect', 'started_at', 'finished_at', 'wpm', 'created_at', 'updated_at');
    }
}
