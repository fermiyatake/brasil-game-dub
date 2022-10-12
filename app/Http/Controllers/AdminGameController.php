<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Platform;
use App\Models\Studio;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminGameController extends Controller
{
    public function create()
    {
        return $this->edit(new Game());
    }

    public function edit(Game $game)
    {
        $platforms = Platform::all();
        $studios = Studio::all();

        return view('admin.games.edit')->with(compact('game', 'platforms', 'studios'));
    }

    public function store(Request $request)
    {
        return $this->update($request, new Game());
    }

    public function update(Request $request, Game $game)
    {
        $game->title = $request->title;
        $game->slug = $request->slug;
        $game->release_date = Carbon::createFromFormat('d/m/Y', $request->date)->format('Y-m-d');
        $game->additional_data = $request->additional;

        $game->platforms()->sync($request->platforms);
        $game->studios()->sync($request->studios);

        $game->save();

        return redirect(route('games.edit', [$game]))->with(['success' => 'Jogo salvo com sucesso!']);
    }
}
