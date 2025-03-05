<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ServiceController extends Controller {
    public function index() {
        $user = Auth::user();
        $services = Service::where('active', true)->get();

        return view('services.index', compact('services'));
    }
}
