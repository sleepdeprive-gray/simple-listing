<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    public function index()
    {
        $items = DB::select('
            SELECT id, name, quantity, created_at
            FROM items
            WHERE deleted_at IS NULL
            ORDER BY id DESC
        ');

        $trashedItems = DB::select("
            SELECT id, name, quantity, deleted_at
            FROM items
            WHERE deleted_at IS NOT NULL
            ORDER BY deleted_at DESC
        ");

        return view('index', compact('items', 'trashedItems'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:2|max:100',
            'quantity' => 'required|integer|min:0|max:10000',
        ]);

        DB::insert("
            INSERT INTO items (name, quantity, created_at, updated_at)
            VALUES (?, ?, NOW(), NOW())
        ", [
            $request->input('name'),
            $request->input('quantity'),
        ]);

        return redirect()->back()->with('success', 'Item added successfully');
    }

    public function updateName(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|min:2|max:100',
        ]);

        DB::update("
            UPDATE items
            SET name = ?, updated_at = NOW()
            WHERE id = ? AND deleted_at IS NULL
        ", [
            $request->input('name'),
            $id,
        ]);

        return redirect()->back()->with('success', 'Item name updated');
    }

    public function updateQuantity(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:0|max:10000',
        ]);

        DB::update("
            UPDATE items
            SET quantity = ?, updated_at = NOW()
            WHERE id = ? AND deleted_at IS NULL
        ", [
            $request->input('quantity'),
            $id,
        ]);

        return redirect()->back()->with('success', 'Quantity updated');
    }

    public function decrement($id)
    {
        DB::update("
            UPDATE items
            SET quantity = GREATEST(0, quantity - 1), updated_at = NOW()
            WHERE id = ? AND deleted_at IS NULL
        ", [
            $id,
        ]);

        return redirect()->back()->with('success', 'Quantity decremented');
    }

    public function increment($id)
    {
        DB::update("
            UPDATE items
            SET quantity = quantity + 1, updated_at = NOW()
            WHERE id = ? AND deleted_at IS NULL
        ", [
            $id,
        ]);

        return redirect()->back()->with('success', 'Quantity incremented');
    }

    public function delete($id)
    {
        DB::update("
            UPDATE items
            SET deleted_at = NOW()
            WHERE id = ? AND deleted_at IS NULL
        ", [
            $id,
        ]);

        return redirect()->back()->with('success', 'Item deleted');
    }

    public function restore($id)
    {
        DB::update("
            UPDATE items
            SET deleted_at = NULL, updated_at = NOW()
            WHERE id = ? AND deleted_at IS NOT NULL
        ", [
            $id,
        ]);

        return redirect()->back()->with('success', 'Item restored');
    }
}
