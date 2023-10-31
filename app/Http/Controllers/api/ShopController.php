<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function readAll() {
        $shops = Shop::with('laundries')->get();

        return response()->json([
            'data' => $shops
        ]);
    }

    public function readRecommendationLimit() {
        $shops = Shop::orderBy('rate', 'desc')->limit(5)->with('laundries')->get();

        if (count($shops) > 0) {
            return response()->json([
                'data' => $shops
            ]);
        } else {
            return response()->json([
                'message' => 'not found',
                'data' => []
            ], 404);
        }

    }

    public function searchByCity($name) {
        $shops = Shop::where('city','like','%'.$name.'%',)->orderBy('name')->with('laundries')->get();

        if (count($shops) > 0) {
            return response()->json([
                'data' => $shops
            ]);
        } else {
            return response()->json([
                'message' => 'not found',
                'data' => []
            ], 404);
        }

    }
}
