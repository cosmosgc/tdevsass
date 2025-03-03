<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller {
    public function index() {
        $services = Service::where('active', true)->get();
        return view('services.index', compact('services'));
    }
}
