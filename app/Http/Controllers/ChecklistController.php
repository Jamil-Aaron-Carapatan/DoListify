<?php

namespace App\Http\Controllers;
use App\Models\ChecklistItem;

use Illuminate\Http\Request;

class ChecklistController extends Controller
{
    public function toggle(Request $request, ChecklistItem $item)
    {
        $item->update(['is_completed' => $request->is_completed]);
        return response()->json(['success' => true]);
    }

    public function update(Request $request, ChecklistItem $item)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $item->update($validated);
        return response()->json(['success' => true, 'name' => $item->name]);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'task_id' => 'required|exists:tasks,id',
            'name' => 'required|string|max:255',
        ]);
        $item = ChecklistItem::create($validated);
        return response()->json($item);
    }


}
