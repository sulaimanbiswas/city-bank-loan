<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Limit;
use Illuminate\Http\Request;

class LimitController extends Controller
{
    // Show edit form for the singleton limits settings
    public function edit()
    {
        $limit = Limit::query()->first();
        if (!$limit) {
            $limit = new Limit();
        }
        return view('admin.limit.edit', compact('limit'));
    }

    // Update the singleton limits settings
    public function update(Request $request)
    {
        $validated = $request->validate([
            'min_deposit' => ['nullable', 'numeric', 'min:0', 'lte:max_deposit'],
            'max_deposit' => ['nullable', 'numeric', 'min:0', 'gte:min_deposit'],
            'min_withdraw' => ['nullable', 'numeric', 'min:0', 'lte:max_withdraw'],
            'max_withdraw' => ['nullable', 'numeric', 'min:0', 'gte:min_withdraw'],
        ]);

        $limit = Limit::query()->first();
        if (!$limit) {
            $limit = new Limit();
        }

        $limit->fill($validated);
        $limit->save();

        return redirect()->route('admin.limit.edit')->with('status', 'Limits updated successfully');
    }
}
