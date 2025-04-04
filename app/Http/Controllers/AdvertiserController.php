<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAdvertisementRequest;
use App\Models\Ad;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdvertiserController extends Controller
{
    public function index()
    {
        $user = User::findOrFail(Auth::id());
        $advertisements = $user->advertisements;

        return view('ads.index', compact('advertisements'));
    }

    public function create()
    {
        return view('ads.create');
    }

    public function store(StoreAdvertisementRequest $request)
    {
        $user = Auth::user();

        if ($user->advertisements()->count() >= 4) {
            return redirect()
                ->route('advertisements.index')
                ->with('error', 'You can only create a maximum of 4 advertisements.');
        }

        $imagePath = $request->file('image')->store('ads', 'public');

        Ad::create([
            'user_id' => $user->id,
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'image' => $imagePath,
            'ads_starttime' => $request->input('ads_starttime'),
            'ads_endtime' => $request->input('ads_endtime'),
            'type' => $request->input('type'),
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('advertisements.index');
    }

    public function edit(string $id)
    {
        $ad = Ad::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        return view('ads.edit', compact('ad'));
    }

    public function update(StoreAdvertisementRequest $request, string $id)
    {
        $ad = Ad::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        $data = $request->only([
            'title',
            'description',
            'ads_starttime',
            'ads_endtime',
            'type',
            'is_active',
        ]);

        // If a new image is uploaded, replace the old one
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('ads', 'public');
            $data['image'] = $imagePath;
        }

        $ad->update($data);

        return redirect()->route('advertisements.index');
    }

    public function show(string $id) {}

    public function destroy(string $id)
    {
        $ad = Ad::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $ad->delete();

        return redirect()->route('advertisements.index')->with('success', 'Advertisement deleted.');
    }
}
