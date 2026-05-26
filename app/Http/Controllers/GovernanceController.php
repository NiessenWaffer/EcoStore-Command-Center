<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class GovernanceController extends Controller
{
    /**
     * Display the governance hub.
     */
    public function index(): View
    {
        return view('governance.index');
    }

    /**
     * Display a specific proposal.
     */
    public function show(string $id): View
    {
        return view('governance.show', compact('id'));
    }

    /**
     * Admin: Manage proposals.
     */
    public function adminIndex(): View
    {
        return view('admin.governance');
    }
}
