@props([
    'weekDates',
    'events' => [],
    'title' => 'Agenda Overview',
    'addButtonRoute' => null,
    'addButtonLabel' => '+ Add Booking',
    'routeName' => 'profile.calendar',
    'firstEventName' => 'Pickup: ',
    'secondEventName' => 'Return: ',
])

@php
    use Illuminate\Support\Str;
    use Carbon\Carbon;

    $startOfWeek = $weekDates->first();
    $prevWeek = $startOfWeek->copy()->subWeek()->toDateString();
    $nextWeek = $startOfWeek->copy()->addWeek()->toDateString();
@endphp

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-gray-800">{{ $title }}</h2>

        <div class="flex items-center space-x-2">
            <a href="{{ route($routeName, ['week_start' => $prevWeek]) }}"
               class="px-3 py-2 bg-gray-100 text-gray-600 rounded hover:bg-gray-200 transition">
                <i class="fa-solid fa-chevron-left"></i>
            </a>

            <span class="font-medium text-gray-700 text-sm">
                {{ $weekDates->first()->format('M d') }} – {{ $weekDates->last()->format('M d') }}
            </span>

            <a href="{{ route($routeName, ['week_start' => $nextWeek]) }}"
               class="px-3 py-2 bg-gray-100 text-gray-600 rounded hover:bg-gray-200 transition">
                <i class="fa-solid fa-chevron-right"></i>
            </a>

            <a href="{{ route($routeName) }}"
               class="ml-3 px-4 py-2 bg-gray-100 text-gray-700 text-sm rounded-md hover:bg-gray-200 transition">
                Today
            </a>

            @if ($addButtonRoute)
                <a href="{{ $addButtonRoute }}"
                   class="ml-3 px-4 py-2 bg-primary text-white text-sm rounded-md hover:bg-primary/80 transition">
                    {{ $addButtonLabel }}
                </a>
            @endif
        </div>
    </div>

    <div class="overflow-x-auto rounded-lg shadow-sm border border-gray-200 bg-white">
        <div class="min-w-[900px]">
            <div class="grid grid-cols-8 border-b border-gray-200 bg-gray-50 text-xs font-semibold text-gray-600">
                <div class="px-4 py-3 text-left">Time</div>
                @foreach ($weekDates as $date)
                    <div class="py-3 text-center {{ $date->isToday() ? 'bg-primary text-white rounded' : 'text-gray-600' }}">
                        {{ Str::substr($date->format('l'), 0, 2) }}<br>
                        <span class="text-xs {{ $date->isToday() ? 'text-white-400' : 'text-gray-400' }}">{{ $date->format('M d') }}</span>
                    </div>
                @endforeach
            </div>

            <div class="max-h-[600px] overflow-y-scroll relative calendar-scroll-container">

                @php  $now = Carbon::now('Europe/Amsterdam'); @endphp
                <div class="absolute left-0 right-0 h-px bg-primary"
                     style="top: calc({{ $now->hour * 5 + ($now->minute / 12) }}rem); z-index: 10;">
                    <div class="w-2 h-2 bg-primary rounded-full absolute -top-1 left-0"></div>
                </div>

                @for ($hour = 0; $hour < 24; $hour++)
                    <div class="grid grid-cols-8 border-t border-gray-100 text-sm">
                        <div class="px-4 py-4 text-gray-400 font-mono text-xs whitespace-nowrap">
                            {{ str_pad($hour, 2, '0', STR_PAD_LEFT) }}:00
                        </div>

                        @foreach ($weekDates as $day)
                            <div class="relative border-l  border-gray-100 h-20">
                                @foreach ($events as $event)
                                    @php
                                        $pickup = Carbon::parse($event['start_datetime']);
                                        $return = Carbon::parse($event['end_datetime']);
                                    @endphp
                                    @if ($pickup->isSameDay($day) && $pickup->hour === $hour)
                                        <a href="" class="absolute inset-1 px-2 py-1 rounded-md text-xs font-medium {{ $event['color']['bg'] }} {{ $event['color']['text'] }} shadow-sm">
                                            <div class="text-xs flex justify-between">
                                                <span class="text-xs font-semibold">{{ $pickup->format('H:i') }}</span>
                                                    <span class="block text-[10px] text-gray-600">
                                                        – {{ $return->format($pickup->isSameYear(now()) ? 'm-d H:i' : 'y-m-d H:i') }}
                                                    </span>
                                            </div>
                                            {{ $firstEventName }} {{ $event['product'] }}
                                            @if(!empty($event['customer']))
                                            <span class="block text-[10px] text-gray-600">Customer: {{ $event['customer'] }}</span>
                                            @endif
                                        </a>
                                    @endif
                                    @if ($return->isSameDay($day) && $return->hour === $hour)
                                        <a href="" class="absolute inset-1 px-2 py-1 rounded-md text-xs font-medium {{ $event['color']['bg'] }} {{ $event['color']['text'] }} opacity-70 shadow-sm">
                                            <span class="block font-semibold text-xs">{{ $return->format('H:i') }}</span>
                                            {{ $secondEventName }} {{ $event['product'] }}
                                            <span class="block text-[10px] text-gray-600">← {{ $event['customer'] }}</span>
                                        </a>
                                    @endif
                                @endforeach

                            </div>
                        @endforeach
                    </div>
                @endfor
            </div>
        </div>
    </div>
    <div class="mt-10 bg-white shadow-sm rounded-lg border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-800">Week overview</h3>
        </div>

        <div class="divide-y divide-gray-100">
            @foreach ($weekDates as $day)
                @php
                    $dayEvents = collect($events)->filter(function ($event) use ($day) {
                        return Carbon::parse($event['start_datetime'])->isSameDay($day) ||
                            Carbon::parse($event['end_datetime'])->isSameDay($day);
                    })->sortBy(fn($e) => Carbon::parse($e['start_datetime']));
                @endphp

                <div class="px-6 py-4">
                    <div class="text-sm font-semibold text-gray-500 mb-2">
                        {{ $day->format('l, M d') }}
                    </div>

                    @if ($dayEvents->isEmpty())
                        <p class="text-sm text-gray-400 italic">No events</p>
                    @else
                        <ul class="space-y-2">
                            @foreach ($dayEvents as $event)
                                @php
                                    $pickup = Carbon::parse($event['start_datetime']);
                                    $return = Carbon::parse($event['end_datetime']);
                                @endphp
                                <li class="flex justify-between items-center p-3  {{ $event['color']['bg'] }} {{ $event['color']['text'] }} rounded-lg ">
                                    <div>
                                        <p class="text-sm font-medium">
                                            {{ $event['product'] }}
                                        </p>
                                        <p class="text-xs text-gray-500">
                                            @if ($pickup->isSameDay($day))
                                               {{ $firstEventName }} {{ $pickup->format('H:i') }} ->
                                               {{ $secondEventName }}{{ $return->format('H:i') }}
                                            @endif
                                            @if ($return->isSameDay($day))
                                                @if (!$pickup->isSameDay($day))
                                                   {{ $secondEventName }}{{ $return->format('H:i') }}
                                                @else
                                                    • {{ $secondEventName }} {{ $return->format('H:i') }}
                                                @endif
                                            @endif
                                        </p>
                                    </div>                                        
                                     @if(!empty($event['customer']))
                                        <span class="text-xs text-gray-500">Customer: {{ $event['customer'] }}</span>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const scrollContainer = document.querySelector('.calendar-scroll-container');
        if (scrollContainer) {
            scrollContainer.scrollTop = 7 * 80;
        }
    });
</script>
