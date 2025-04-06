<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BusinessSettingsController extends Controller
{
    public function edit()
    {
        $user = Auth::user();

        $business = $user->business ?? $user->business()->create([
            'company_name' => 'My Company', 
        ]);

        $fonts = ['Instrument Sans', 'Poppins', 'Inter', 'Roboto', 'Lato'];

        return view('profile.settings', compact('business', 'fonts'));
    }


    public function update(Request $request)
    {
        $request->validate([
            'primary_color' => 'nullable|string|max:20',
            'font_family' => 'nullable|string|max:100',
            'logo' => 'nullable|image|max:2048',
        ]);

        $business = Auth::user()->business;

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('logos', 'public');
            $business->logo_path = $path;
        }

        $business->primary_color = $request->primary_color;
        $business->font_family = $request->font_family;
        $business->save();

        return redirect()->back()->with('success', 'Settings updated!');
    }
}
