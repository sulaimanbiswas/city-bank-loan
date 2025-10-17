<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->string('q')->toString();
        $plans = Plan::when($q, function ($query) use ($q) {
            $query->where('label', 'like', "%{$q}%")
                ->orWhere('value', 'like', "%{$q}%");
        })->paginate(15)->withQueryString();
        return view('admin.plans.index', compact('plans'));
    }

    public function create()
    {
        return view('admin.plans.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'label' => ['nullable', 'string', 'max:255'],
            'type' => ['required', 'in:amount,duration,reason'],
            'value' => ['nullable', 'string', 'max:255'],
            'interest_rate' => ['required', 'numeric', 'min:0'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        // Map single selected type to the persisted 'types' string column
        $validated['types'] = $validated['type'];
        unset($validated['type']);

        Plan::create($validated);
        return redirect()->route('admin.plans.index')->with('status', 'Plan created');
    }

    public function edit(Plan $plan)
    {
        return view('admin.plans.edit', compact('plan'));
    }

    public function update(Request $request, Plan $plan)
    {
        $validated = $request->validate([
            'label' => ['nullable', 'string', 'max:255'],
            'type' => ['required', 'in:amount,duration,reason'],
            'value' => ['nullable', 'string', 'max:255'],
            'interest_rate' => ['required', 'numeric', 'min:0'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        $validated['types'] = $validated['type'];
        unset($validated['type']);

        $plan->update($validated);
        return redirect()->route('admin.plans.index')->with('status', 'Plan updated');
    }

    public function destroy(Plan $plan)
    {
        $plan->delete();
        return back()->with('status', 'Plan deleted');
    }

    public function toggle(Plan $plan)
    {
        $plan->status = $plan->status === 'active' ? 'inactive' : 'active';
        $plan->save();
        return back()->with('status', 'Plan status updated');
    }
}
