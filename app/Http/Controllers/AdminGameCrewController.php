<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Professional;
use App\Models\Voice;
use Illuminate\Http\Request;

class AdminGameCrewController extends Controller
{
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
