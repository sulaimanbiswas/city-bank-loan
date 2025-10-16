<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GatewayController extends Controller
{
    public function index(Request $request)
    {
        $q = (string) $request->string('q');
        $type = (string) $request->string('type');

        $gateways = Gateway::query()
            ->when($q, fn($query) => $query->where('method', 'like', "%{$q}%"))
            ->when(in_array($type, ['deposit', 'withdraw'], true), fn($query) => $query->where('type', $type))
            ->latest()->paginate(15)->withQueryString();

        return view('admin.gateways.index', compact('gateways'));
    }

    public function create()
    {
        return view('admin.gateways.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => ['required', 'in:deposit,withdraw'],
            'method' => ['required', 'string', 'max:255'],
            'account_number' => ['nullable', 'string', 'max:255', 'required_if:type,deposit'],
            'status' => ['required', 'in:active,inactive'],
            'logo' => ['nullable', 'image', 'mimes:png,jpg,jpeg,webp', 'max:2048'],
        ]);

        $data = [
            'type' => $validated['type'],
            'method' => $validated['method'],
            'account_number' => $validated['account_number'] ?? null,
            'status' => $validated['status'],
        ];

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('gateways', 'public');
            $data['logo_path'] = $path;
        }

        Gateway::create($data);
        return redirect()->route('admin.gateways.index')->with('status', 'Gateway created');
    }

    public function edit(Gateway $gateway)
    {
        return view('admin.gateways.edit', compact('gateway'));
    }

    public function update(Request $request, Gateway $gateway)
    {
        $validated = $request->validate([
            'type' => ['required', 'in:deposit,withdraw'],
            'method' => ['required', 'string', 'max:255'],
            'account_number' => ['nullable', 'string', 'max:255', 'required_if:type,deposit'],
            'status' => ['required', 'in:active,inactive'],
            'logo' => ['nullable', 'image', 'mimes:png,jpg,jpeg,webp', 'max:2048'],
        ]);

        $gateway->fill([
            'type' => $validated['type'],
            'method' => $validated['method'],
            'account_number' => $validated['account_number'] ?? null,
            'status' => $validated['status'],
        ]);

        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($gateway->logo_path) {
                Storage::disk('public')->delete($gateway->logo_path);
            }
            $path = $request->file('logo')->store('gateways', 'public');
            $gateway->logo_path = $path;
        }

        $gateway->save();
        return redirect()->route('admin.gateways.index')->with('status', 'Gateway updated');
    }

    public function destroy(Gateway $gateway)
    {
        if ($gateway->logo_path) {
            Storage::disk('public')->delete($gateway->logo_path);
        }
        $gateway->delete();
        return back()->with('status', 'Gateway deleted');
    }

    public function toggle(Gateway $gateway)
    {
        $gateway->status = $gateway->status === 'active' ? 'inactive' : 'active';
        $gateway->save();
        return back()->with('status', 'Gateway status updated');
    }
}
