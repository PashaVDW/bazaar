<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;

class ReservationService
{
    public function reserve(int $productId, string $startTime, string $endTime): bool|string
    {
        $product = Product::with('reservations')->findOrFail($productId);

        for ($index = 0; $index < $product->stock; $index++) {
            $hasConflict = Reservation::where('product_id', $product->id)
                ->where('stock_index', $index)
                ->where(function ($query) use ($startTime, $endTime) {
                    $query->whereBetween('start_time', [$startTime, $endTime])
                        ->orWhereBetween('end_time', [$startTime, $endTime])
                        ->orWhere(function ($q) use ($startTime, $endTime) {
                            $q->where('start_time', '<=', $startTime)
                                ->where('end_time', '>=', $endTime);
                        });
                })
                ->exists();

            if (! $hasConflict) {
                Reservation::create([
                    'user_id' => Auth::id(),
                    'product_id' => $product->id,
                    'stock_index' => $index,
                    'start_time' => $startTime,
                    'end_time' => $endTime,
                ]);

                return true;
            }
        }

        return 'No available stock for the selected period.';
    }
}
