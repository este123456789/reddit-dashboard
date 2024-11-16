<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Theme;

class ImportRedditThemes extends Command
{
    protected $signature = 'reddit:import-themes';
    protected $description = 'Importar temas desde Reddit';

    public function handle()
    {
        // Realizar la solicitud HTTP a la URL de Reddit
        $response = Http::get('https://www.reddit.com/reddits.json');
        $data = $response->json();

        // Extraer los temas desde el JSON
        $themes = $data['data']['children'];

        foreach ($themes as $themeData) {
            $theme = $themeData['data'];

            // Insertar los temas en la base de datos
            Theme::create([
                'display_name' => $theme['display_name'],
                'title' => $theme['title'],
                'description_html' => $theme['description_html'],
                'subscribers' => $theme['subscribers'],
                'name' => $theme['name'],
            ]);
        }

        $this->info('Temas importados exitosamente.');
    }
}
