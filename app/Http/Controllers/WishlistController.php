<?php
namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlists = Wishlist::with('concert')
            ->where('user_id', Auth::id())
            ->get();

        return response()->json($wishlists);
    }

    public function store(Request $request)
    {
        $request->validate([
            'concert_id' => 'required|exists:concerts,id',
        ]);

        $exists = Wishlist::where('user_id', Auth::id())
            ->where('concert_id', $request->concert_id)
            ->exists();

        if ($exists) {
            return response()->json(['message' => 'Concert already in wishlist'], 409);
        }

        $wishlist = Wishlist::create([
            'user_id'    => Auth::id(),
            'concert_id' => $request->concert_id,
        ]);

        return response()->json($wishlist->load('concert'), 201);
    }

    public function destroy($id)
    {
        $wishlist = Wishlist::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $wishlist->delete();
        return response()->json(['message' => 'Removed from wishlist']);
    }

    public function countByConcert($concertId)
    {
        $count = Wishlist::where('concert_id', $concertId)->count();
        return response()->json(['concert_id' => $concertId, 'wishlist_count' => $count]);
    }
}