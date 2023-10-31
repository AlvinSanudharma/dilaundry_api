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
}
