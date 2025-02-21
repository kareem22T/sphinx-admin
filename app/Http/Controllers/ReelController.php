<?php

namespace App\Http\Controllers;

use App\Models\Reel;
use Illuminate\Http\Request;

class ReelController extends Controller
{
    // Fetch the latest reels
    public function index()
    {
        $reels = Reel::latest()->take(10)->get();
        return response()->json($reels);
    }

    // Fetch the next reel
    public function next($currentReelId)
    {
        $nextReel = Reel::where('id', '>', $currentReelId)->orderBy('id', 'asc')->first();

        if ($nextReel) {
            return response()->json($nextReel);
        }

        return response()->json(['message' => 'No more reels available'], 404);
    }

    // Fetch the previous reel
    public function prev($currentReelId)
    {
        $prevReel = Reel::where('id', '<', $currentReelId)->orderBy('id', 'desc')->first();

        if ($prevReel) {
            return response()->json($prevReel);
        }

        return response()->json(['message' => 'No more reels available'], 404);
    }
}
