<?php

namespace Database\Seeders;

use App\Models\Reservation;
use App\Models\ReturnRequest;
use Illuminate\Database\Seeder;

class ReturnRequestSeeder extends Seeder
{
    public function run(): void
    {
        $reservation = Reservation::first();

        if ($reservation) {
            ReturnRequest::create([
                'reservation_id' => $reservation->id,
                'photo_path' => 'returns/sample.jpg',
                'submitted_at' => now(),
            ]);
        }
    }
}
