<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class ClearCache extends Command
{
    /**
     * O nome e a assinatura do comando.
     *
     * @var string
     */
    protected $signature = 'app:clear-cache';

    /**
     * A descrição do comando.
     *
     * @var string
     */
    protected $description = 'Limpa o cache da aplicação';

    /**
     * Execute o comando.
     *
     * @return int
     */
    public function handle()
    {
        Artisan::call('cache:clear');
        $this->info('Cache cleared successfully!');
    }
}
