<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PlayerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // On récupère tous les utilisateurs avec leurs clubs associés
        $players = Player::with('club')->get();
        // On retourne les informations des utilisateurs en JSON
        return response()->json($players);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'firstName' => 'required|max:100',
            'lastName' => 'required|max:100',
            'height' => 'required|max:100',
            'position' => 'required|max:100',
        ]);

        $filename = "";
        if ($request->hasFile('photoPlayer')) {
            $filenameWithExt = $request->file('photoPlayer')->getClientOriginalName();
            $filenameWithoutExt = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('photoPlayer')->getClientOriginalExtension();
            $filename = $filenameWithoutExt . '_' . time() . '.' . $extension;
            $path = $request->file('photoPlayer')->storeAs('public/uploads', $filename);
        } else {
            $filename = null;
        }

        $player = Player::create(array_merge($request->all(), ['photoPlayer' => $filename]));

        return response()->json([
            'status' => 'Success',
            'data' => $player,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Player $player)
    {
        // On retourne les informations de l'utilisateur en JSON
        return response()->json($player);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Player $player)
    {
        $request->validate([
            'firstName' => 'required|max:100',
            'lastName' => 'required|max:100',
            'height' => 'required|max:100',
            'position' => 'required|max:100',
            'club_id' => 'required|exists:clubs,id',
            'photoPlayer' => 'nullable|image|max:2048',
             
        ]);

        $player->update($request->all());

        return response()->json([
            'status' => 'Mise à jour avec succès',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Player $player)
    {
        if ($player->photoPlayer) {
            Storage::delete('public/uploads/' . $player->photoPlayer);
        }
        $player->delete();
        
        return response()->json([
            'status' => 'Suppression avec succès',
        ]);
    }
}