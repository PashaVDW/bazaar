<?php

namespace App\Services;

use App\Models\Ad;
use Illuminate\Http\Request;

class AdSearchService
{
    public function search(Request $request)
    {
        $query = Ad::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($type = $request->input('type')) {
            $query->where('type', $type);
        }

        if ($priceMin = $request->input('price_min')) {
            $query->where('hourly_price', '>=', $priceMin);
        }

        if ($priceMax = $request->input('price_max')) {
            $query->where('hourly_price', '<=', $priceMax);
        }

        if ($dateStart = $request->input('date_start')) {
            $query->whereDate('ads_starttime', '>=', $dateStart);
        }

        if ($dateEnd = $request->input('date_end')) {
            $query->whereDate('ads_endtime', '<=', $dateEnd);
        }

        switch ($request->input('sort')) {
            case 'price_low_high':
                $query->orderBy('hourly_price', 'asc');
                break;
            case 'price_high_low':
                $query->orderBy('hourly_price', 'desc');
                break;
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        return $query->paginate(12)->withQueryString();
    }
}
