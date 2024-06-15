<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GameSettings;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class GameSettingsController extends Controller
{
    public function store(Request $request)
    {
        // Получаем данные о настройках игры из запроса
        $data = $request->only(['actionCount', 'speed', 'examples', 'gameName', 'session_id']);

        // Проверка полученных данных
        if (!isset($data['actionCount']) || !isset($data['speed']) || !isset($data['examples']) || !isset($data['gameName'])) {
            return response()->json(['message' => 'Invalid data'], 400);
        }

        // Генерация уникального идентификатора сессии
        $sessionId = (string) Str::uuid();

        // Получаем ID текущего пользователя
        $userId = auth()->user()->id;

        // Проверяем, существует ли запись для данного пользователя и игры
        $gameSettings = GameSettings::where('user_id', $userId)
            ->where('game_name', $data['gameName'])
            ->first();

            // Если записи нет, создаем новую
            $gameSettings = new GameSettings();
        $gameSettings->session_id = $data['session_id'];
            $gameSettings->user_id = $userId; // ID текущего пользователя
            $gameSettings->game_name = $data['gameName']; // Добавление game_name
            $gameSettings->action_count = $data['actionCount'];
            $gameSettings->speed = $data['speed'];
            $gameSettings->examples = $data['examples'];
            $gameSettings->save();

        // Возвращаем успешный ответ
        return response()->json(['message' => 'Game settings saved successfully'], 200);
    }
}
