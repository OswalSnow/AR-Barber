<?php

namespace App\Http\Controllers;

use App\Models\PortfolioImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PortfolioImageController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $path = $request->file('image')->store('portfolio', 'public');

        PortfolioImage::create([
            'path' => $path
        ]);

        return back()->with('success', '¡Foto subida con éxito!');
    }

    // AQUÍ ESTÁ LA NUEVA FUNCIÓN PARA BORRAR
    public function destroy($id)
    {
        $image = PortfolioImage::findOrFail($id);
        Storage::disk('public')->delete($image->path); // Borra el archivo
        $image->delete(); // Borra el registro
        return back()->with('success', 'Foto eliminada');
    }
}