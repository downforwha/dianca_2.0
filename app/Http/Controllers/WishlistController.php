<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Session;

class WishlistController extends Controller
{
    public function toggle(Request $request, $productId)
    {
        $sessionId = Session::getId();
        
        $wishlist = Wishlist::where('product_id', $productId)
                            ->where('session_id', $sessionId)
                            ->first();

        if ($wishlist) {
            $wishlist->delete();
            return response()->json(['status' => 'removed']);
        } else {
            Wishlist::create([
                'product_id' => $productId,
                'session_id' => $sessionId,
                'ip_address' => $request->ip(),
            ]);
            return response()->json(['status' => 'added']);
        }
    }
}
