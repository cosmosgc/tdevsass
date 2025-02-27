<?php
namespace Services\SocialScheduler\Console\Commands;

use Illuminate\Console\Command;

class MeuComando extends Command
{
    protected $signature = 'meu-modulo:executar';
    protected $description = 'Executa uma ação do módulo';

    public function handle()
    {
        $this->info('Comando executado com sucesso!');
    }
}
