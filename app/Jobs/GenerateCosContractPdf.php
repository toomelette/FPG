<?php

namespace App\Jobs;

use App\Models\HRU\COSEmployees;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Spatie\Browsershot\Browsershot;
use Spatie\LaravelPdf\Facades\Pdf;

class GenerateCosContractPdf implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Batchable;

    /**
     * Create a new job instance.
     */

    public int $cosEmpId;
    public string $slug;
    public string $folder;
    public int $totalCount;

    public $timeout = 300; // Browsershot needs time
    public $tries = 3;

    public function __construct(
        int $cosEmpId,
        string $slug,
        string $folder,
        int $totalCount
    )
    {
        $this->cosEmpId = $cosEmpId;
        $this->slug = $slug;
        $this->folder = $folder;
        $this->totalCount = $totalCount;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $cosEmp = COSEmployees::with(['cos','employee.responsibilityCenter'])
            ->findOrFail($this->slug);

        Pdf::view('printables.hru.cos.contract', [
            'pdfPrint' => true,
            'cosEmps' => [$cosEmp],
        ])
            ->paperSize(215.9, 330.2)
            ->margins(20, 20, 20, 20)
            ->headers(['title' => 'aaaaa'])
            ->footerView(
                'printables.hru.hr-requests.contract-of-service-footer',
                ['totalCount' => $this->totalCount]
            )
            ->name('Contract of Service.pdf')
            ->withBrowsershot(function (Browsershot $browsershot) {
                if (app()->environment('production')) {
                    $browsershot
                        ->setNodeBinary(env('NODE_BINARY'))
                        ->setNpmBinary(env('NPM_BINARY'));
                }
            })
            ->disk('contracts_temp')
            ->save("/{$this->folder}/{$this->slug}.pdf");

    }
}
