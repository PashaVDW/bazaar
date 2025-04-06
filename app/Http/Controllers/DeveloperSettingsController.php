<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeveloperSettingsController extends Controller
{
    public function index()
    {
        $tokens = Auth::user()->tokens()->orderByDesc('created_at')->get();

        return view('developer.index', [
            'tokens' => $tokens,
            'newTokenId' => session('newTokenId'),
            'plainTextToken' => session('plainTextToken'),
        ]);
    }

    public function createToken(Request $request)
    {
        $request->validate([
            'token_name' => 'required|string|max:255',
        ]);

        $createdToken = Auth::user()->createToken($request->token_name);

        return redirect()->route('developer.index')->with([
            'newTokenId' => $createdToken->accessToken->id,
            'plainTextToken' => $createdToken->plainTextToken,
        ]);
    }

    public function destroy($id)
    {
        Auth::user()->tokens()->where('id', $id)->delete();

        return redirect()->back()->with('success', 'Token deleted.');
    }
}
