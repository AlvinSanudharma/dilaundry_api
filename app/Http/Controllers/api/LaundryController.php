<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Laundry;
use App\Models\User;
use Illuminate\Http\Request;

class LaundryController extends Controller
{
    public function readAll() {
        $laundries = Laundry::with(['user', 'shop'])->get();

        return response()->json([
            'data' => $laundries
        ]);
    }

    public function whereUserId($id) {
        $laundries = Laundry::where('user_id', $id)->with(['shop','user'])->orderBy('created_at', 'desc')->get();

        if (count($laundries) > 0) {
            return response()->json([
                'data' => $laundries
            ]);
        } else {
            return response()->json([
                'message' => 'not found',
                'data' => []
            ], 404);
        }
    }

    public function claim(Request $request) {
        $laundry = Laundry::where([
            ['id','=', $request->id],
            ['claim_code','=', $request->claim_code],
        ])->first();

        if (!$laundry) {
            return response()->json([
                'message' => 'not found',
            ], 404);
        }

        if ($laundry->user_id != 0) {
            return response()->json([
                'message' => 'laundry has been claim',
            ], 400);
        }

        $laundry->user_id = $request->user_id;
        $updated = $laundry->save();

        if ($updated) {
            return response()->json([
                'data' => $updated
            ], 201);
        } else {
            return response()->json([
                'message' => "can't be update",
            ], 500);
        }
    }
}
