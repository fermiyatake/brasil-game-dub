<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Platform;
use App\Models\Professional;
use App\Models\Studio;
use App\Models\Voice;
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
        $professionals = Professional::all();

        return view('admin.games.edit')->with(compact('game', 'platforms', 'studios', 'professionals'));
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

        if(!$game->id)
            $game->cover = Game::NO_COVER;
        
        $game->save();

        $game->platforms()->sync($request->platforms);
        $game->studios()->sync($request->studios);

        return redirect(route('games.edit', [$game]))->with('success', 'Jogo salvo com sucesso!');
    }

    public function editVoiceCast(Game $game)
    {
        $professionals = Professional::orderBy('name')->get();

        return view('admin.games.manager.voices')->with(compact('game', 'professionals'));
    }

    public function updateVoiceCast(Request $request, Game $game)
    {
        $voicework = $this->mountVoiceCollection($request);

        $game->voices()->detach();

        foreach($voicework as $work)
        {
            $voice = new Voice();

            $voice->character = $work->character;
            $voice->section_name = $work->group ?? 'Principais';
            $voice->professional_id = $work->professional;
            $voice->game_id = $game->id;

            $voice->save();

            $game->voices()->attach($game->id, ['voice_id' => $voice->id]); 
        }

        return redirect()->back()->with('success', 'Elenco alterado com sucesso!');
    }

    public function mountVoiceCollection(Request $request) 
    {
        $voices = [];

        foreach($request->character as $key=>$character)
        {
            $voices[$key]['character'] = $character;
            $voices[$key]['professional'] = $request->professional[$key];
            $voices[$key]['group'] = $request->group[$key];
        }

        return Voice::hydrate($voices);
    }
}
