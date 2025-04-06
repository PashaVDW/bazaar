<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profile.index');
    }

    public function purchaseHistory()
    {
        $purchases = Auth::user()
            ->purchases()
            ->with(['products.ad'])
            ->whereHas('products', function ($query) {
                $query->whereIn('type', ['sale', 'auction']);
            })
            ->whereNotNull('purchased_at')
            ->orderByDesc('purchased_at')
            ->paginate(5);

        return view('purchases.purchase', [
            'purchases' => $purchases,
            'type' => 'purchase',
        ]);
    }

    public function rentalHistory()
    {
        $user = Auth::user();

        $reservations = $user->reservations()
            ->with(['product', 'returnRequest'])
            ->orderByDesc('created_at')
            ->paginate(5);

        $ownsRentalProducts = $user->products()->where('type', 'rental')->exists();

        $ownedReservations = collect();

        if ($ownsRentalProducts) {
            $ownedReservations = Reservation::with('user', 'product', 'returnRequest')
                ->whereHas('product', function ($q) use ($user) {
                    $q->where('user_id', $user->id)->where('type', 'rental');
                })
                ->latest()
                ->get();
        }

        return view('purchases.rental', compact('reservations', 'ownedReservations', 'ownsRentalProducts'));
    }

    public function showPurchase(int $id)
    {
        $purchase = Auth::user()
            ->purchases()
            ->with('products.ad')
            ->findOrFail($id);

        return view('purchases.show', compact('purchase'));
    }
}
