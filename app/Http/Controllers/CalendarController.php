<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;

class CalendarController extends Controller
{

    
    public function index(Request $request)
    {
        $startOfWeek = $request->query('week_start')
            ? Carbon::parse($request->query('week_start'))->startOfWeek()
            : now()->startOfWeek();

        $dates = collect(range(0, 6))->map(fn ($i) => $startOfWeek->copy()->addDays($i));

        $customers = ['Jane Doe', 'John Smith', 'Alice Johnson'];

        $colorMap = [];

        foreach ($customers as $customer) {
            $colorMap[$customer] = $this->randomTailwindColorUnique();
        }
        $events = [
            [
                'start_datetime' => '2025-04-10 10:00',
                'end_datetime' => '2025-04-12 16:00',
                'product' => 'Canon EOS 250D',
                'customer' => 'Jane Doe',
                'color' => $colorMap['Jane Doe'],
            ],
            [
                'start_datetime' => '2025-04-11 09:00',
                'end_datetime' => '2025-04-13 15:00',
                'product' => 'Nikon D5600',
                'customer' => 'John Smith',
                'color' =>  $colorMap['John Smith'],

            ],
            [
                'start_datetime' => '2025-04-12 13:00',
                'end_datetime' => '2025-04-14 10:00',
                'product' => 'Sony A6400',
                'customer' => 'Alice Johnson',
                'color' =>  $colorMap['Alice Johnson'],
            ],
        ];
        return view('profile.calendar', [
            'weekDates' => $dates,
            'startOfWeek' => $startOfWeek,
            'events' => $events,
        ]);
    }
    public function randomTailwindColorUnique(): array
    {
        $colors = [
            'red', 'orange', 'amber', 'yellow', 'lime', 'green', 'emerald',
            'teal', 'cyan', 'blue', 'indigo', 'violet', 'purple', 'pink', 'rose'
        ];
    
        $used = session()->get('used_colors', []);
    
        $available = array_values(array_diff($colors, $used));
    
        if (empty($available)) {
            $available = $colors;
            $used = [];
        }
    
        $color = $available[array_rand($available)];
    
        $used[] = $color;
        session()->put('used_colors', $used);
    
        return [
            'bg' => "bg-{$color}-100",
            'text' => "text-{$color}-800",
        ];
    }
}
