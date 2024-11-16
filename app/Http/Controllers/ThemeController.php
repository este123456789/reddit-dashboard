<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

use App\Models\Theme;
use Illuminate\Http\Request;



class ThemeController extends Controller
{
    // Obtener todos los temas
    public function index()
    {
        $themes = Theme::all();
        return response()->json($themes);
    }

    // Obtener un tema específico
    public function show($id)
    {
        $theme = Theme::findOrFail($id);
        return response()->json($theme);
    }

    // Método para obtener y guardar los últimos 10 temas de Reddit
    public function importLast10Themes()
    {
        // Obtener los datos del JSON desde Reddit
        $response = Http::get('https://www.reddit.com/reddits.json');
        $data = $response->json();

        // Extraer los últimos 10 temas
        $themes = array_slice($data['data']['children'], 0, 10);

        $savedThemes = [];

        foreach ($themes as $themeData) {
            $theme = $themeData['data'];

            // Verificar si el tema ya está en la base de datos
            $existingTheme = Theme::where('name', $theme['name'])->first();

            // Si el tema no existe, lo insertamos
            if (!$existingTheme) {
                $savedTheme = Theme::create([
                    'display_name' => $theme['display_name'],
                    'title' => $theme['title'],
                    'description_html' => $theme['description_html'],
                    'subscribers' => $theme['subscribers'],
                    'name' => $theme['name'],
                ]);

                $savedThemes[] = $savedTheme;
            }
        }

        // Responder con los temas que fueron guardados
        return response()->json([
            'message' => 'Los últimos 10 temas han sido importados.',
            'themes' => $savedThemes,
        ]);
    }


}
