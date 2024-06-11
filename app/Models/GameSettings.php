<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameSettings extends Model
{
    protected $table = 'game_settings'; // Указываем имя таблицы в базе данных, с которой связана эта модель

    protected $fillable = ['user_id', 'action_count', 'speed', 'examples']; // Указываем, какие поля можно заполнять массово

    public function user()
    {
        return $this->belongsTo(User::class); // Устанавливаем связь "Принадлежит одному пользователю"
    }
}
