<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class LocationController extends Controller
{
    public function getLocation(Request $request)
    {
        // Mendapatkan IP pengguna
        $ip = $request->ip();

        // Mendapatkan URL API dari environment
        $apiUrl = env('FREEGEOIP_API_URL');

        // Membuat instance dari Guzzle HTTP Client
        $client = new Client();

        try {
            // Melakukan GET request ke FreeGeoIP API
            $response = $client->get($apiUrl . $ip);

            // Mendapatkan data respons dalam bentuk JSON
            $locationData = json_decode($response->getBody(), true);

            // Mengembalikan data lokasi dalam format JSON
            return response()->json($locationData);
        } catch (\Exception $e) {
            // Mengembalikan pesan kesalahan jika terjadi error
            return response()->json(['error' => 'Failed to fetch location.'], 500);
        }
    }

    public function saveLocation(Request $request)
    {
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');
        $accuracy = $request->input('accuracy');

        // Simpan data lokasi ke database atau lakukan tindakan lainnya

        return response()->json(['success' => true, 'latitude' => $latitude, 'longitude' => $longitude, 'accuracy' => $accuracy]);
    }
}
