<?php

namespace App\Console\Commands;

use App\Models\Destination;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ExportDestinations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'destinations:export {--filename=destinations.csv : The name of the CSV file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export all destinations to a CSV file';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $destinations = Destination::all();
        $filename = $this->option('filename');
        
        if (empty($destinations->count())) {
            $this->error('No destinations found to export.');
            return 1;
        }
        
        $csvContent = "name,description,price,duration\n";
        
        foreach ($destinations as $destination) {
            $csvContent .= sprintf(
                '"%s","%s",%s,%s' . "\n",
                str_replace('"', '""', $destination->name),
                str_replace('"', '""', $destination->description),
                $destination->price,
                $destination->duration
            );
        }
        
        Storage::disk('public')->put($filename, $csvContent);
        
        $this->info('Destinations exported successfully to: ' . Storage::disk('public')->path($filename));
        
        return 0;
    }
}