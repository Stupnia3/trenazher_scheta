<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;



/**
 *
 *
 * @property-read \App\Models\User|null $teacher
 * @method static \Illuminate\Database\Eloquent\Builder|Student newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Student newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Student query()
 * @mixin \Eloquent
 */
class Student extends Model
{
    use HasFactory;

    protected $table = 'users'; // Указываем таблицу, с которой связана модель

    protected $fillable = [
        'name', 'email', // Здесь перечислите все поля, которые вы хотите разрешить для массового заполнения
    ];

    // Пример отношения с учителем, если ученик привязан к учителю
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
}
