<?php

namespace App\Http\Controllers;

use App\Http\Requests\FinalizeReturnRequest;
use App\Http\Requests\SubmitReturnRequest;
use App\Models\Reservation;
use App\Models\ReturnRequest;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function returnForm(Reservation $reservation)
    {
        if ($reservation->user_id !== Auth::id()) {
            abort(403);
        }

        return view('reservations.return', compact('reservation'));
    }

    public function submitReturn(SubmitReturnRequest $request, Reservation $reservation)
    {
        if ($reservation->user_id !== Auth::id()) {
            abort(403);
        }

        $photoPath = $request->file('photo')->store('returns', 'public');

        ReturnRequest::create([
            'reservation_id' => $reservation->id,
            'photo_path' => $photoPath,
            'submitted_at' => now(),
        ]);

        return redirect()->route('profile.rentalHistory')->with('toast', [
            'type' => 'success',
            'message' => 'Return request submitted.',
        ]);
    }

    public function reviewReturn(Reservation $reservation)
    {
        if ($reservation->product->user_id !== Auth::id()) {
            abort(403);
        }

        if (! $reservation->returnRequest) {
            return redirect()->route('profile.rentalHistory')->with('toast', [
                'type' => 'danger',
                'message' => 'No return request submitted for this reservation.',
            ]);
        }

        return view('reservations.review', compact('reservation'));
    }

    public function finalizeReturn(FinalizeReturnRequest $request, Reservation $reservation)
    {
        if ($reservation->product->user_id !== Auth::id()) {
            abort(403);
        }

        $reservation->returned_at = now();
        $reservation->wear_percentage = $request->wear_percentage;
        $reservation->save();

        return redirect()->route('profile.rentalHistory')->with('toast', [
            'type' => 'success',
            'message' => 'Return finalized successfully.',
        ]);
    }
}
