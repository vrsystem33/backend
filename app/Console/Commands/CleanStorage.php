<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class CleanStorage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:clean-storage';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove todos os arquivos do diretório storage/public';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $disk = Storage::disk('public');

        // Obter todos os diretórios dentro do diretório público
        $directories = $disk->allDirectories();

        // Remover cada diretório
        foreach ($directories as $directory) {
            $disk->deleteDirectory($directory);
        }

        $this->info('Diretório de storage limpo com sucesso.');
    }
}
