<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
{
    public function rentalCalendar(Request $request)
{
    $startOfWeek = $request->query('week_start')
        ? Carbon::parse($request->query('week_start'))->startOfWeek()
        : now()->startOfWeek();

    $weekDates = collect(range(0, 6))->map(fn ($i) => $startOfWeek->copy()->addDays($i));

    $user = Auth::user();

    // Reserveringen van huidige gebruiker (als huurder)
    $ownReservations = $user->reservations()->with('product')->get();

    // Reserveringen van producten die de gebruiker aanbiedt (als verhuurder)
    $productReservations = \App\Models\Reservation::with(['product', 'user'])
        ->whereHas('product', fn($query) => $query->where('user_id', $user->id)->where('type', 'rental'))
        ->get();

    // Kleurenschema’s
    $colors = [
        'own' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-800'],
        'customer' => ['bg' => 'bg-green-100', 'text' => 'text-green-800'],
    ];

    // Combineer beide
    $events = collect();

    foreach ($ownReservations as $res) {
        $events->push([
            'start_datetime' => $res->start_time,
            'end_datetime' => $res->end_time,
            'product' => $res->product->name ?? 'Unknown',
            'customer' => $user->name,
            'color' => $colors['own'],
        ]);
    }

    foreach ($productReservations as $res) {
        $events->push([
            'start_datetime' => $res->start_time,
            'end_datetime' => $res->end_time,
            'product' => $res->product->name ?? 'Unknown',
            'customer' => $res->user->name ?? 'Customer',
            'color' => $colors['customer'],
        ]);
    }

    return view('profile.rentalCalendar', [
        'weekDates' => $weekDates,
        'startOfWeek' => $startOfWeek,
        'events' => $events,
    ]);
}


    public function adsCalendar(Request $request)
    {
        $startOfWeek = $request->query('week_start')
            ? Carbon::parse($request->query('week_start'))->startOfWeek()
            : now()->startOfWeek();

        $weekDates = collect(range(0, 6))->map(fn ($i) => $startOfWeek->copy()->addDays($i));

        $ads = Ad::where('user_id', Auth::id())->get();

        $adKeys = $ads->pluck('id')->map(fn ($id) => (string) $id)->toArray();
        $colorMap = $this->assignUniqueColors($adKeys);

        $events = $ads->map(fn ($ad) => [
            'start_datetime' => $ad->ads_starttime,
            'end_datetime' => $ad->ads_endtime,
            'product' => $ad->title,
            'customer' => 'Your Ad',
            'color' => $colorMap[(string) $ad->id],
        ]);

        return view('ads.ads-calendar', [
            'weekDates' => $weekDates,
            'startOfWeek' => $startOfWeek,
            'events' => $events,
        ]);
    }

    private function assignUniqueColors(array $keys): array
    {
        $colors = [
            ['bg' => 'bg-red-100', 'text' => 'text-red-800'],
            ['bg' => 'bg-orange-100', 'text' => 'text-orange-800'],
            ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800'],
            ['bg' => 'bg-green-100', 'text' => 'text-green-800'],
            ['bg' => 'bg-blue-100', 'text' => 'text-blue-800'],
            ['bg' => 'bg-indigo-100', 'text' => 'text-indigo-800'],
            ['bg' => 'bg-purple-100', 'text' => 'text-purple-800'],
            ['bg' => 'bg-pink-100', 'text' => 'text-pink-800'],
            ['bg' => 'bg-rose-100', 'text' => 'text-rose-800'],
        ];

        $assigned = [];
        $usedIndexes = [];

        foreach ($keys as $key) {
            $hash = crc32($key);
            $index = $hash % count($colors);

            while (in_array($index, $usedIndexes)) {
                $index = ($index + 1) % count($colors);
            }

            $assigned[$key] = $colors[$index];
            $usedIndexes[] = $index;
        }

        return $assigned;
    }
}
