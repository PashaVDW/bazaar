<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReviewRequest;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function create()
    {
        $productId = request('product');

        $product = Product::whereHas('purchases', function ($q) {
            $q->where('user_id', Auth::id());
        })->findOrFail($productId);

        $userId = Auth::id();

        $productReview = Review::where('user_id', $userId)
            ->where('product_id', $productId)
            ->whereNull('reviewed_user_id')
            ->first();

        $advertiserReview = Review::where('user_id', $userId)
            ->where('reviewed_user_id', $product->user_id)
            ->whereNull('product_id')
            ->first();

        return view('reviews.create', compact('product', 'productReview', 'advertiserReview'));
    }

    public function store(StoreReviewRequest $request)
    {
        $data = $request->validated();
        $userId = Auth::id();

        foreach ($data['review_type'] as $type) {
            if ($type === 'product') {
                Review::updateOrCreate(
                    [
                        'user_id' => $userId,
                        'product_id' => $data['product_id'],
                        'reviewed_user_id' => null,
                    ],
                    [
                        'title' => $data['title'],
                        'content' => $data['content'],
                        'rating' => $data['rating'],
                    ]
                );
            }

            if ($type === 'advertiser') {
                Review::updateOrCreate(
                    [
                        'user_id' => $userId,
                        'product_id' => null,
                        'reviewed_user_id' => $data['advertiser_id'],
                    ],
                    [
                        'title' => $data['title'],
                        'content' => $data['content'],
                        'rating' => $data['rating'],
                    ]
                );
            }
        }

        return redirect()->route('profile.purchaseHistory')->with('success', 'Review submitted.');
    }
}
