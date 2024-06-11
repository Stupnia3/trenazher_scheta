<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameResult extends Model
{
    use HasFactory;

    protected $table = 'game_results';

    protected $fillable = [
        'user_id',
        'game_name',
        'score',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
