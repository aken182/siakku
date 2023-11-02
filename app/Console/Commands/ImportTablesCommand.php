<?php

namespace App\Console\Commands;

use App\Http\Controllers\ImportTablesController;
use Illuminate\Console\Command;

class ImportTablesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:tables';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import beberapa tabel ke database';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(ImportTablesController $controller)
    {
        $this->info('Starting import...');
        $controller->import();
        $this->info('Import Completed');
        return Command::SUCCESS;
    }
}
