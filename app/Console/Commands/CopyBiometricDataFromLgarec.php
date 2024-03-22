<?php

namespace App\Console\Commands;

use App\Swep\Services\DTRService;
use Illuminate\Console\Command;

class CopyBiometricDataFromLgarec extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dtr:copy_from_lgarec';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(DTRService $DTRService)
    {
        $DTRService->extractViaApi();
        return Command::SUCCESS;
    }
}
