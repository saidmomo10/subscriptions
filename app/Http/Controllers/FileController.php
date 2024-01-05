<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;

class FileController extends Controller
{
    public function addFiles()
    {
        return view('filesViews.addFiles');
    }

    public function createFile(Request $request)
    {
        // Validation des données du formulaire
        $request->validate([
            'name' => 'required',
        ]);

        // Créer un nouvel abonnement
        $file = new File([
            // 'user_id' => auth()->user()->id,
            // 'start_date' => now(),
            'name' => $request->input('name'),
        ]);
       $file->save();

        return back()->with('message', 'chaîne créé avec succès!');
    }
}