<?php

namespace App\Console\Commands\ESD;

use App\Models\ESD\EG\EquipmentGroundDetail;
use App\Models\ESD\Flooring\FlooringDetail;
use App\Models\ESD\Garment\GarmentDetail;
use App\Models\ESD\GB\GroundMonitorBoxDetail;
use App\Models\ESD\Glove\GloveDetail;
use App\Models\ESD\Ionizer\IonizerDetail;
use App\Models\ESD\Jig\JigDetail;
use App\Models\ESD\Packaging\PackagingDetail;
use App\Models\ESD\Soldering\SolderingDetail;
use App\Models\ESD\Worksurface\WorksurfaceDetail;
use App\Models\ESD\WS\WristStrap;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class UpdateRemarksAfterDeadline extends Command
{
    protected $signature = 'schedule:update-remarks';
    protected $description = 'Update remarks from "Schedule On" to "Delay" after 15:00 for today created records, and send grouped notification per model';

    public function handle()
    {
        $now = Carbon::now();
        $today = Carbon::today();

        if (!($now->hour === 15 && $now->minute === 0)) {
            $this->info('Bukan jam 15:00, proses dibatalkan.');
            return 0;
        }

        $models = [
            EquipmentGroundDetail::class     => 'equipment-ground-details',
            FlooringDetail::class            => 'flooring-details',
            GarmentDetail::class             => 'garment-details',
            GroundMonitorBoxDetail::class    => 'ground-monitor-box-details',
            IonizerDetail::class             => 'ionizer-details',
            JigDetail::class                 => 'jig-details',
            PackagingDetail::class           => 'packaging-details',
            SolderingDetail::class           => 'soldering-details',
            WorksurfaceDetail::class         => 'worksurface-details',
            WristStrap::class                => 'wrist-straps',
            GloveDetail::class               => 'glove-details',
        ];

        $baseUrl = 'https://portal.siix-ems.co.id/esd';
        $totalUpdated = 0;
        $updatesByModel = [];

        // Single pass through all data
        foreach ($models as $modelClass => $slug) {
            $recordsToUpdate = $modelClass::whereDate('created_at', $today)
                ->where('remarks', 'Schedule On')
                ->get();

            $count = $recordsToUpdate->count();

            if ($count > 0) {
                // Batch update
                foreach ($recordsToUpdate as $record) {
                    $record->remarks = 'Delay';
                    $record->save();
                }

                $updatesByModel[$modelClass] = [
                    'count' => $count,
                    'slug' => $slug,
                ];

                $totalUpdated += $count;

                $this->info("Updated {$count} records in {$modelClass}.");
            }
        }

        // Log notifications per model
        foreach ($updatesByModel as $modelClass => $data) {
            $count = $data['count'];
            $slug = $data['slug'];
            $url = "{$baseUrl}{$slug}";
            $modelName = class_basename($modelClass);

            Log::channel('daily')->info("Schedule Delay in {$modelName}", [
                'count' => $count,
                'url' => $url,
            ]);

            $this->line("Delay detected for {$modelName}: {$count} record(s).");
        }

        // No delay case
        if ($totalUpdated === 0) {
            Log::channel('daily')->info("No Delay Detected", [
                'message' => 'All equipment today are On Schedule.',
            ]);

            $this->info("No data updated. All equipment are on schedule.");
        }

        $this->info("Total updated records: {$totalUpdated}");
        return 0;
    }
}