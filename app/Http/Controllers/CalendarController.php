<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
{
    public function index(Request $request)
    {
        $startOfWeek = $request->query('week_start')
            ? Carbon::parse($request->query('week_start'))->startOfWeek()
            : now()->startOfWeek();

        $dates = collect(range(0, 6))->map(fn ($i) => $startOfWeek->copy()->addDays($i));

        $eventsRaw = [
            [
                'start_datetime' => '2025-04-10 10:00',
                'end_datetime' => '2025-04-12 16:00',
                'product' => 'Canon EOS 250D',
                'customer' => 'Jane Doe',
            ],
            [
                'start_datetime' => '2025-04-11 09:00',
                'end_datetime' => '2025-04-13 15:00',
                'product' => 'Nikon D5600',
                'customer' => 'John Smith',
            ],
            [
                'start_datetime' => '2025-04-12 13:00',
                'end_datetime' => '2025-04-14 10:00',
                'product' => 'Sony A6400',
                'customer' => 'Alice Johnson',
            ],
        ];

        $customers = collect($eventsRaw)->pluck('customer')->unique()->toArray();
        $colorMap = $this->assignUniqueColors($customers);

        $events = collect($eventsRaw)->map(fn ($event) => [
            ...$event,
            'color' => $colorMap[$event['customer']],
        ]);

        return view('profile.calendar', [
            'weekDates' => $dates,
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
