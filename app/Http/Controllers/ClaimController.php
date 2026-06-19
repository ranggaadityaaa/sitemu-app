<?php

namespace App\Http\Controllers;

use App\Models\Claim;
use App\Models\Item;
use Illuminate\Http\Request;
use App\Events\NewClaimNotification;

class ClaimController extends Controller
{
    public function store(Request $request, Item $item)
{
    $request->validate([
        'message' => 'required|string|min:10',
    ]);

    $claim = Claim::create([
        'item_id' => $item->id,
        'user_id' => auth()->id(),
        'message' => $request->message,
    ]);

    broadcast(new NewClaimNotification($claim, $item->user_id, $item->title))->toOthers();

    $pesan = $item->type == 'found'
        ? 'Klaim berhasil dikirim! Tunggu konfirmasi pemilik.'
        : 'Info temuan berhasil dikirim! Terima kasih sudah membantu.';

    return back()->with('success', $pesan);
}

    public function approve(Claim $claim)
    {
        $claim->update(['status' => 'approved']);
        $claim->item->update(['status' => 'matched']);
        return back()->with('success', 'Klaim disetujui! Barang sudah ditemukan ✅');
    }

    public function reject(Claim $claim)
    {
        $claim->update(['status' => 'rejected']);
        return back()->with('success', 'Klaim ditolak.');
    }
}