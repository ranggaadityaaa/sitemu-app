<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\User;
use App\Models\Claim;
use Illuminate\Http\Request;

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
    public function users()
{
    $users = User::where('role', '!=', 'admin')->latest()->paginate(10);
    return view('admin.users', compact('users'));
}

public function banUser(Request $request, User $user)
{
    $request->validate([
        'ban_reason' => 'required|string|max:255',
    ]);

    $user->update([
        'is_banned' => true,
        'ban_reason' => $request->ban_reason,
    ]);

    return back()->with('success', 'User berhasil di-banned!');
}

public function unbanUser(User $user)
{
    $user->update([
        'is_banned' => false,
        'ban_reason' => null,
    ]);

    return back()->with('success', 'User berhasil di-unban!');
}
}