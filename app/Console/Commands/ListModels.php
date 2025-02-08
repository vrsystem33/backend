<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ListModels extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:list-models';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List all model classes in the application';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $models = [];

        // Diretório de models
        $modelDirectory = app_path('Models');

        // Verifique se o diretório existe
        if (File::exists($modelDirectory)) {
            // Buscar arquivos nas subpastas
            $directories = File::directories($modelDirectory);

            // Iterar sobre os diretórios de modelos
            foreach ($directories as $directory) {
                $files = File::allFiles($directory);

                // Adicionar modelos nas subpastas com o caminho correto
                foreach ($files as $file) {
                    $models[] = 'app\\Models\\' . basename($directory) . '\\' . $file->getBasename('.php') . '.php';
                }
            }

            // Buscar os modelos que estão diretamente no diretório Models
            $files = File::allFiles($modelDirectory);
            foreach ($files as $file) {
                if (is_file($file)) {
                    $models[] = 'app\\Models\\' . $file->getBasename('.php') . '.php';
                }
            }
        }

        // Remover duplicatas
        $models = array_unique($models);

        // Exiba os modelos encontrados
        if (count($models) > 0) {
            $this->info("Models found:");
            foreach ($models as $model) {
                $this->line($model);
            }
        } else {
            $this->error("No models found.");
        }
    }
}
