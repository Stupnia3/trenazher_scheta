<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GameSettings;
use Illuminate\Support\Facades\Log;

class GameSettingsController extends Controller
{
    public function store(Request $request)
    {
        // Получаем данные о настройках игры из запроса
        $data = $request->only(['actionCount', 'speed', 'examples', 'gameName']);

        // Проверка полученных данных
        if (!isset($data['actionCount']) || !isset($data['speed']) || !isset($data['examples']) || !isset($data['gameName'])) {
            return response()->json(['message' => 'Invalid data'], 400);
        }

        // Получаем ID текущего пользователя
        $userId = auth()->user()->id;

        // Проверяем, существует ли запись для данного пользователя и игры
        $gameSettings = GameSettings::where('user_id', $userId)
            ->where('game_name', $data['gameName'])
            ->first();

        if ($gameSettings) {
            // Если запись существует, обновляем данные
            $gameSettings->action_count = $data['actionCount'];
            $gameSettings->speed = $data['speed'];
            $gameSettings->examples = $data['examples'];
            $gameSettings->save();
        } else {
            // Если записи нет, создаем новую
            $gameSettings = new GameSettings();
            $gameSettings->user_id = $userId; // ID текущего пользователя
            $gameSettings->game_name = $data['gameName']; // Добавление game_name
            $gameSettings->action_count = $data['actionCount'];
            $gameSettings->speed = $data['speed'];
            $gameSettings->examples = $data['examples'];
            $gameSettings->save();
        }

        // Возвращаем успешный ответ
        return response()->json(['message' => 'Game settings saved successfully'], 200);
    }
}
