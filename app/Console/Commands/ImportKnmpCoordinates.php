<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Knmp;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ImportKnmpCoordinates extends Command
{
    protected $signature = 'knmp:import-coordinates {file?}';
    protected $description = 'Import KNMP coordinates from Excel file';

    public function handle()
    {
        $filePath = $this->argument('file') ?? public_path('Koordinat KNMP.xlsx');
        
        if (!file_exists($filePath)) {
            $this->error("File not found: {$filePath}");
            return 1;
        }

        $this->info("Reading file: {$filePath}");
        
        $reader = IOFactory::createReader('Xlsx');
        $spreadsheet = $reader->load($filePath);
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray();
        
        // Show headers
        $headers = $rows[0];
        $this->info("Headers: " . implode(', ', array_filter($headers)));
        
        // Expected format: No, Nama Desa, Koordinat
        // Koordinat format: "lat, lng" or "lat,lng"
        
        // First, reset all coordinates
        Knmp::query()->update(['latitude' => null, 'longitude' => null]);
        $this->info("Reset all existing coordinates.");
        
        $updated = 0;
        $notFound = [];
        $invalidCoord = [];
        
        // Process data rows (skip header)
        for ($i = 1; $i < count($rows); $i++) {
            $row = $rows[$i];
            $nama = trim($row[1] ?? ''); // Nama Desa is column 1
            $koordinat = trim($row[2] ?? ''); // Koordinat is column 2
            
            if (empty($nama) || empty($koordinat)) continue;
            
            // Parse koordinat (format: "lat,lng" or "lat, lng")
            $parts = explode(',', $koordinat);
            if (count($parts) !== 2) {
                $invalidCoord[] = "{$nama}: {$koordinat}";
                continue;
            }
            
            $lat = floatval(trim($parts[0]));
            $lng = floatval(trim($parts[1]));
            
            if ($lat == 0 || $lng == 0) {
                $invalidCoord[] = "{$nama}: {$koordinat} (invalid numbers)";
                continue;
            }
            
            // Find KNMP by desa name - try exact match first on nama field
            $knmp = Knmp::where('nama', 'LIKE', '%' . $nama . '%')->first();
            
            if (!$knmp) {
                // Try matching on desa relation
                $knmp = Knmp::whereHas('desa', function($q) use ($nama) {
                    $q->where('name', 'LIKE', '%' . $nama . '%');
                })->first();
            }
            
            if ($knmp) {
                $knmp->update([
                    'latitude' => $lat,
                    'longitude' => $lng,
                ]);
                $updated++;
                $this->line("✓ [{$i}] {$knmp->nama} → ({$lat}, {$lng})");
            } else {
                $notFound[] = $nama;
            }
        }
        
        $this->newLine();
        $this->info("=== Summary ===");
        $this->info("Updated: {$updated} KNMP");
        $this->info("Not found: " . count($notFound));
        $this->info("Invalid coordinates: " . count($invalidCoord));
        
        if (count($notFound) > 0 && count($notFound) <= 20) {
            $this->warn("KNMP not found in database:");
            foreach ($notFound as $name) {
                $this->line("  - {$name}");
            }
        }
        
        if (count($invalidCoord) > 0) {
            $this->warn("Invalid coordinates:");
            foreach ($invalidCoord as $item) {
                $this->line("  - {$item}");
            }
        }
        
        return 0;
    }
}

