<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller {

    public function index(){
        $items = DB::select('
            SELECT id, name, quantity, created_at
            FROM items
            WHERE deleted_at IS NULL
            ORDER BY id DESC
        ');

        $tashedItems = DB::select("
            SELECT id name, quantiy, deleted_at
            FROM items
            WHERE deleted_at IS NOT Null
            ORDER BY deleted_at DESC
        
        ");

        return  view('item.index',  compact('items', 'tashedItems'));
      
    }

    public function store(Request $request) {

        request->validate([
            'name' => 'required|string|min:2|max:100',
            'quantity' => 'required|integer|min:0|max:10000'
        ]);

        $result = DB::insert("
            INSERT INTO item (name, quantity, created_at, update_at)
            VALUES (?, ?, NOW(), NOW());
        ", [
            $request->input('name'),
            $request->input('quantity'),
        ]);

    }

    public function updateName(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|min:2|max:100',
        ]);

        $result = DB::update("
            UPDATE items
            SET name = ?, updated_at = NOW()
            where id = ? AND deleted_at  IS NULL
        ", [
            $request->input('name'),
            $id,
        ])

    public function decrement ($id)
    {
        $result = DB::update(" 
            UPDATE items
            SET quantity = GREATEST(0, quantity - 1), updated_at = NOW()
                WHERE id = ? AND deleted_at IS NULL
        ", [
            $id,
        ]);

        return redirect()->back();

    public function restore($id) {

        DB::update("
            UPDATE items
            SET deleted_at = NULL, updated_at NOW()
            WHERE id = ? AND deleted_at IS NOT NULL
        ", [
            $id,
        ]);

        return redirect()->back()->with('success', 'Item restored');
    }

    
    }

}
