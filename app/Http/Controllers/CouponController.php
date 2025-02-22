<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CouponController extends Controller
{
    public function checkCoupon(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string',
            'tour_id' => 'nullable|integer',
            'hotel_id' => 'nullable|integer',
        ]);

        $coupon = Coupon::where('coupon_code', $request->coupon_code)
            ->where(function ($query) use ($request) {
                if ($request->filled('tour_id')) {
                    $query->whereJsonContains('tours', (string) $request->tour_id);
                }
                if ($request->filled('hotel_id')) {
                    $query->whereJsonContains('hotels', (string) $request->hotel_id);
                }
            })
            ->whereDate('start_date', '<=', Carbon::now())
            ->whereDate('end_date', '>=', Carbon::now())
            ->first();

        if (!$coupon) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid or expired coupon.',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'discount_percentage' => $coupon->discount_percentage,
        ]);
    }
}
