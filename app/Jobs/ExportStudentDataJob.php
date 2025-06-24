<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Exports\StudentExport;
use App\Models\StudentExportJob;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;

class ExportStudentDataJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $exportId;

    public function __construct($exportId)
    {
        $this->exportId = $exportId;
    }

    /**
     * Execute the job.
    */
    public function handle(): void
    {
        $exportData = StudentExportJob::find($this->exportId);
        try {
        Excel::store(new StudentExport, 'public/exports/' . $exportData->file_name);

        $exportData->update([
            'status' => 'completed',
            'completed_at' => now(),
            ]);
        }catch(\Exception $e){
             $exportData->update([
            'status' => 'error',
            Log::error('Data Export Error:' . $e->getMessage()),
        ]);
             
        }

    }
}
