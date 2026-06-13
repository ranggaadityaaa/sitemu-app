<?php

namespace App\Http\Controllers;

use App\Models\Item;    
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index(Request $request)
{
    $query = Item::with('user')->where('status', 'open');

    if ($request->search) {
        $query->where('title', 'like', '%' . $request->search . '%')
              ->orWhere('location', 'like', '%' . $request->search . '%');
    }

    if ($request->type) {
        $query->where('type', $request->type);
    }

    if ($request->category) {
        $query->where('category', $request->category);
    }

    $items = $query->latest()->paginate(10);
    return view('items.index', compact('items'));
}
    public function create()
    {
        return view('items.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'type'        => 'required|in:lost,found',
            'title'       => 'required|string|max:100',
            'description' => 'required|string',
            'category'    => 'required|string',
            'location'    => 'required|string',
            'date'        => 'required|date',
            'photo'       => 'nullable|image|max:2048',
        ]);

        $data = $request->all();
        $data['user_id'] = auth()->id();

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('items', 'public');
        }

        Item::create($data);
        return redirect()->route('items.index')->with('success', 'Laporan berhasil dibuat!');
    }

    public function show(Item $item)
    {
        $claims = $item->claims()->with('user')->get();
        return view('items.show', compact('item', 'claims'));
    }

    public function destroy(Item $item)
    {
        $item->delete();
        return redirect()->route('items.index')->with('success', 'Laporan dihapus!');
    }

    public function edit(Item $item)
{
    if (auth()->id() != $item->user_id) {
        abort(403);
    }
    return view('items.edit', compact('item'));
}

public function update(Request $request, Item $item)
{
    if (auth()->id() != $item->user_id) {
        abort(403);
    }

    $request->validate([
        'type'        => 'required|in:lost,found',
        'title'       => 'required|string|max:100',
        'description' => 'required|string',
        'category'    => 'required|string',
        'location'    => 'required|string',
        'date'        => 'required|date',
        'photo'       => 'nullable|image|max:2048',
    ]);

    $data = $request->except('photo');

    if ($request->hasFile('photo')) {
        $data['photo'] = $request->file('photo')->store('items', 'public');
    }

    $item->update($data);
    return redirect()->route('items.show', $item)->with('success', 'Laporan berhasil diupdate!');
    }
}