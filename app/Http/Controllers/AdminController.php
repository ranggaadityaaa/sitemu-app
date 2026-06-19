<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\User;
use App\Models\Claim;

class AdminController extends Controller
{
    public function index()
    {
        $totalItems = Item::count();
        $totalUsers = User::count();
        $totalClaims = Claim::count();
        $totalMatched = Item::where('status', 'matched')->count();
        $items = Item::with('user')->latest()->paginate(10);

        return view('admin.index', compact(
            'totalItems', 'totalUsers',
            'totalClaims', 'totalMatched', 'items'
        ));
    }

    public function deleteItem(Item $item)
    {
        $item->delete();
        return back()->with('success', 'Laporan berhasil dihapus oleh admin!');
    }
}