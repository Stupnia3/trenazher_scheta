<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\GameResult;
use Illuminate\Support\Facades\Log;

class GameResultController extends Controller
{
    public function store(Request $request)
    {
        // Получаем данные о результате игры из запроса
        $data = $request->only(['game_name', 'score', 'session_id']);

        // Получаем ID пользователя
        $userId = auth()->user()->id;

        // Выводим данные в логи
        Log::info('Received data for saving game result:', $data);

        try {
            // Пытаемся найти запись в базе данных по user_id и game_name
            $gameResult = GameResult::where('user_id', $userId)->where('game_name', $data['game_name'])->first();

                // Если запись не найдена, создаем новую запись
                $gameResult = new GameResult();
                $gameResult->session_id = $data['session_id'];
                $gameResult->user_id = $userId;
                $gameResult->game_name = $data['game_name'];
                // Проверяем на отрицательные значения и устанавливаем в 0, если значение отрицательное
                $gameResult->score = $data['score'];
                $gameResult->save();

            // Обновляем общий счет для пользователя и игры
            $this->updateUserTotalScore($userId, $data['game_name']);
            // Возвращаем успешный ответ
            return response()->json(['message' => 'Game result saved successfully', 'game_result' => $gameResult], 201);
        } catch (\Exception $e) {
            // Если возникает ошибка, записываем ее в логи
            Log::error('Error while saving game result: ' . $e->getMessage());

            // Возвращаем ошибку клиенту
            return response()->json(['message' => 'Failed to save game result'], 500);
        }
    }
    private function updateUserTotalScore($userId, $gameName)
    {
        // Получаем все результаты игр данного пользователя для указанной игры
        $gameResults = GameResult::where('user_id', $userId)
            ->where('game_name', $gameName)
            ->get();

        // Инициализируем переменную для подсчета суммы баллов
        $totalScore = 0;
        $scoreAfterZero = 0;

        // Проходимся по всем результатам и суммируем баллы
        foreach ($gameResults as $result) {
            if ($result->score >= 0 || $totalScore > 0) {
                $totalScore += $result->score;
            }
        }

        // Обновляем соответствующее поле в таблице users
        $user = User::find($userId);

        // Выбираем поле в зависимости от имени игры
        switch ($gameName) {
            case 'flash-anzan':
                $user->total_score_flash_anzan = $totalScore;
                break;
            case 'flash-cards':
                $user->total_score_flash_cards = $totalScore;
                break;
            case 'division':
                $user->total_score_division = $totalScore;
                break;
            case 'multiplication':
                $user->total_score_multiplication = $totalScore;
                break;
            case 'columns':
                $user->total_score_columns = $totalScore;
                break;
            default:
                Log::warning('Invalid game name: ' . $gameName);
                return;
        }

        $user->save();
    }



}
