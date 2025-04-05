<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function create(Request $request)
    {
        $adId = $request->query('ad');
        $ad = Ad::whereHas('purchases', function ($q) {
            $q->where('user_id', auth()->id());
        })->findOrFail($adId);

        $review = Review::where('user_id', auth()->id())
            ->where('ad_id', $adId)
            ->first();

        return view('reviews.create', compact('ad', 'review'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'ad_id' => 'required|exists:ads,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        Review::create([
            'user_id' => auth()->id(),
            'ad_id' => $validated['ad_id'],
            'title' => $validated['title'],
            'content' => $validated['content'],
            'rating' => $validated['rating'],
        ]);

        return redirect()->route('profile.purchaseHistory')->with('success', 'Review submitted.');
    }
}
