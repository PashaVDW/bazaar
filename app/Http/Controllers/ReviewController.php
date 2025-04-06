<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function create(Request $request)
    {
        $productId = $request->query('product');
        $product = Product::whereHas('purchases', function ($q) {
            $q->where('user_id', Auth::id());
        })->findOrFail($productId);

        $review = Review::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->first();

        return view('reviews.create', compact('product', 'review'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        Review::updateOrCreate(
            ['user_id' => Auth::id(), 'product_id' => $validated['product_id']],
            [
                'title' => $validated['title'],
                'content' => $validated['content'],
                'rating' => $validated['rating'],
            ]
        );

        return redirect()->route('profile.purchaseHistory')->with('success', 'Review submitted.');
    }
}
