<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Bid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuctionController extends Controller
{
    public function index()
    {
        $products = Product::where('user_id', auth()->id())
            ->where('type', 'auction')
            ->with(['bids' => function ($query) {
                $query->latest();
            }, 'winningBid.user'])
            ->latest()
            ->paginate(10);

        return view('auctions.index', compact('products'));
    }

    public function placeBid(Request $request, Product $product)
    {
        if ($product->type !== 'auction' || $product->is_auction_closed) {
            abort(403);
        }

        $request->validate([
            'amount' => 'required|numeric|min:0.01',
        ]);

        $highestBid = $product->bids()->max('amount');
        if ($request->amount <= $highestBid) {
            return back()->with('error', 'Your bid must be higher than the current highest bid.');
        }

        $product->bids()->create([
            'user_id' => Auth::id(),
            'amount' => $request->amount,
        ]);

        return back()->with('success', 'Bid placed successfully.');
    }

    public function closeAuction(Product $product)
    {
        if ($product->type !== 'auction' || $product->is_auction_closed || $product->user_id !== Auth::id()) {
            abort(403);
        }

        $winningBid = $product->bids()->orderByDesc('amount')->first();

        if ($winningBid) {
            $product->update([
                'is_auction_closed' => true,
                'winning_bid_id' => $winningBid->id,
            ]);

            return back()->with('success', 'Auction closed successfully.');
        }

        $product->delete();

        return back()->with('success', 'Auction closed and product deleted because no bids were placed.');
    }
}
