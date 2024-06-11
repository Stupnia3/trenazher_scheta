<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GameResult;
use Illuminate\Support\Facades\Log;

class GameResultController extends Controller
{
    public function store(Request $request)
    {
        // Получаем данные о результате игры из запроса
        $data = $request->only(['game_name', 'score']);

        // Получаем ID пользователя
        $userId = auth()->user()->id;

        // Выводим данные в логи
        Log::info('Received data for saving game result:', $data);

        try {
            // Пытаемся найти запись в базе данных по user_id и game_name
            $gameResult = GameResult::where('user_id', $userId)->where('game_name', $data['game_name'])->first();

            if ($gameResult) {
                // Если запись найдена, обновляем баллы
                $gameResult->score += $data['score'];
                // Проверяем на отрицательные значения и устанавливаем в 0, если значение отрицательное
                if ($gameResult->score < 0) {
                    $gameResult->score = 0;
                }
                $gameResult->save();
            } else {
                // Если запись не найдена, создаем новую запись
                $gameResult = new GameResult();
                $gameResult->user_id = $userId;
                $gameResult->game_name = $data['game_name'];
                // Проверяем на отрицательные значения и устанавливаем в 0, если значение отрицательное
                $gameResult->score = max(0, $data['score']);
                $gameResult->save();
            }

            // Возвращаем успешный ответ
            return response()->json(['message' => 'Game result saved successfully', 'game_result' => $gameResult], 201);
        } catch (\Exception $e) {
            // Если возникает ошибка, записываем ее в логи
            Log::error('Error while saving game result: ' . $e->getMessage());

            // Возвращаем ошибку клиенту
            return response()->json(['message' => 'Failed to save game result'], 500);
        }
    }


}
