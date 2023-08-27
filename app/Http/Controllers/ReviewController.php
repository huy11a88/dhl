<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Review;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        try {
            $orderId = $request->input('order_id');
            $comment = $request->input('review');

            Review::create([
                'order_id' => $orderId,
                'user_id' => $request->user()->id,
                'comment' => $comment
            ]);
    
            if ($rating = $request->input('rating')) {
                Order::query()->whereKey($orderId)->update(compact('rating'));
            }

            $userName = $request->user()->name;
            $review = [
                'avatar' => strtoupper($userName[0]),
                'user_name' => $userName,
                'time' => now()->toFormattedDateString(),
                'comment' => $comment
            ];
    
            return response()->json(['status' => 'success', 'review' => $review]);
        } catch (Exception $e) {
            return response()->json(['status' => 'error'], 500);
        }
    }

    public function getByOrderId($orderId)
    {
        $reviews = Review::with('user:id,name')->where('order_id', $orderId)
            ->orderBy('created_at')
            ->get()
            ->transform(function ($review) {
                $userName = $review->user->name;
                return [
                    'avatar' => strtoupper($userName[0]),
                    'user_name' => $userName,
                    'time' => $review->created_at->toFormattedDateString(),
                    'comment' => $review->comment
                ];
            });

        return response()->json(['status' => 'success', 'reviews' => $reviews]);
    }
}
