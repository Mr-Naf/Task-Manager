<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subtask;

class SubTaskController extends Controller
{
    public function update(Request $request, $id)
    {
        $subtask = Subtask::findOrFail($id);
        $subtask->is_completed = $request->is_completed;
        $subtask->save();
        return response()->json($subtask);
    }
}
