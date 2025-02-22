<?php

namespace App\Http\Controllers;

use App\Models\Reel;
use Illuminate\Http\Request;

class ReelController extends Controller
{
    // Fetch the latest reels
    public function index()
    {
        $reels = Reel::latest()->get();
        return response()->json($reels);
    }
}
