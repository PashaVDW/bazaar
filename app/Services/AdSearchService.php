<?php

namespace App\Services;

use App\Models\Ad;
use Illuminate\Http\Request;

class AdSearchService
{
    public function search(Request $request)
    {
        $query = Ad::with('products');

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhereHas('products', function ($sub) use ($search) {
                        $sub->where('name', 'like', "%{$search}%");
                    });
            });
        }

        if ($type = $request->input('type')) {
            $query->whereHas('products', function ($q) use ($type) {
                $q->where('type', $type);
            });
        }

        if ($request->filled('price_min') || $request->filled('price_max')) {
            $query->whereHas('products', function ($q) use ($request) {
                if ($request->filled('price_min')) {
                    $q->where('price', '>=', $request->input('price_min'));
                }
                if ($request->filled('price_max')) {
                    $q->where('price', '<=', $request->input('price_max'));
                }
            });
        }

        if ($dateStart = $request->input('date_start')) {
            $query->whereDate('ads_starttime', '>=', $dateStart);
        }

        if ($dateEnd = $request->input('date_end')) {
            $query->whereDate('ads_endtime', '<=', $dateEnd);
        }

        switch ($request->input('sort')) {
            case 'price_low_high':
                $query->withMin('products', 'price')->orderBy('products_min_price');
                break;

            case 'price_high_low':
                $query->withMax('products', 'price')->orderByDesc('products_max_price');
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
