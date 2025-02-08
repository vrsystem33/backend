<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeService extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new service in the App\Services folder';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->argument('name');

        // Removes the 'Service' suffix if it already exists
        $cleanName = str_ends_with($name, 'Service')
            ? substr($name, 0, -7)
            : $name;

        $cleanName = ucfirst(strtolower($cleanName));

        $directory = app_path('Services');
        $fileName = "{$cleanName}Service.php";
        $filePath = "{$directory}/{$fileName}";

        // Certifique-se de que o diretório Services existe
        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        // Verifica se o arquivo já existe
        if (File::exists($filePath)) {
            $this->error("O serviço '{$fileName}' já existe!");
            return Command::FAILURE;
        }

        // Conteúdo do arquivo de serviço
        $stub = <<<PHP
<?php

namespace App\Services;

class {$cleanName}Service
{
    //
}
PHP;

        // Cria o arquivo de serviço
        File::put($filePath, $stub);

        $this->info("Service '{$fileName}' created successfully!");
        return Command::SUCCESS;
    }
}
