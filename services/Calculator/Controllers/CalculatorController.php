<?php
namespace Services\Calculator\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Services\Calculator\CalculatorService; // Fix the namespace

class CalculatorController extends Controller
{
    public function index()
    {
        return view('calculator::index');
    }

    public function calculate(Request $request, CalculatorService $calculator)
    {
        $result = $calculator->calculate(
            $request->input('num1'),
            $request->input('num2'),
            $request->input('operation')
        );

        return response()->json(['result' => $result]);
    }
}
