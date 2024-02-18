<?php

namespace App\Enums;

enum RoleEnum: string
{
    case STUDENT = 'student';
    case TEACHER = 'teacher';
    case ADMIN = 'admin';

    public static function getRoleName(string $role)
    {
        $role = RoleEnum::from($role);
        $array = [
            self::STUDENT->value => 'Студент',
            self::TEACHER->value => 'Преподаватель',
            self::ADMIN->value => 'Администратор',
        ];
        return $array[$role->value];
    }
}
