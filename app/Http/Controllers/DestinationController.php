<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Controller for handling destination pages and data export
 */
class DestinationController extends Controller
{
    /**
     * Display the homepage with a list of destinations
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Get list of destinations with optional name filter
        $query = Destination::query();

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }

        $destinations = $query->latest()->paginate(10);

        return view('destinations.index', compact('destinations'));
    }

    /**
     * Display the specified destination details
     *
     * @param  \App\Models\Destination  $destination
     * @return \Illuminate\View\View
     */
    public function show(Destination $destination)
    {
        return view('destinations.show', compact('destination'));
    }

    /**
     * Export all destinations as a CSV file for download
     *
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function export(): StreamedResponse
    {
        $filename = 'destinations_' . now()->format('Y_m_d_H_i_s') . '.csv';

        // Define CSV headers
        $headers = [
            "Content-Type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        // Create streamed response to handle large datasets efficiently
        return Response::stream(function () {
            $file = fopen('php://output', 'w');

            // Write the CSV column headers
            fputcsv($file, ['name', 'description', 'price', 'duration']);

            // Fetch all destinations and write each row
            Destination::chunk(100, function ($destinations) use ($file) {
                foreach ($destinations as $destination) {
                    fputcsv($file, [
                        $destination->name,
                        $destination->description,
                        $destination->price,
                        $destination->duration
                    ]);
                }
            });

            fclose($file);
        }, 200, $headers);
    }
}
