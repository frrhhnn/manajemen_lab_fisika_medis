<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Legacy redirect to new dashboard controller
     * This controller is kept for backward compatibility only
     */
    public function dashboard(Request $request)
    {
        return redirect()->route('admin.dashboard');
    }

    /**
     * Legacy redirect to equipment management
     */
    public function index()
    {
        return redirect()->route('admin.dashboard');
    }
}