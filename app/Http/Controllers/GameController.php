<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GameResult;

class GameController extends Controller
{
    public function saveGameResult(Request $request) {
        $result = new GameResult();
        $result->username = $request->input('username');
        $result->correct_answers = $request->input('correct_answers');
        $result->incorrect_answers = $request->input('incorrect_answers');
        $result->game_mode = $request->input('game_mode');
        $result->save();

        return response()->json(['message' => 'Результат сохранен']);
    }
}
