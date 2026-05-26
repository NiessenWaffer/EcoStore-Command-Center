<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SustainabilityMetric;
use Illuminate\Http\Request;

class SustainabilityMetricController extends Controller
{
    public function index()
    {
        $metrics = SustainabilityMetric::all();
        return view('admin.metrics', compact('metrics'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'material_type' => 'required|string|unique:sustainability_metrics,material_type',
            'water_per_kg' => 'required|numeric|min:0',
            'carbon_per_kg' => 'required|numeric|min:0',
        ]);

        SustainabilityMetric::create($request->all());

        return redirect()->back()->with('success', 'Metric added successfully.');
    }

    public function destroy(SustainabilityMetric $metric)
    {
        $metric->delete();
        return redirect()->back()->with('success', 'Metric deleted successfully.');
    }
}
