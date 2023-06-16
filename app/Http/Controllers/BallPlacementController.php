<?php

namespace App\Http\Controllers;

use App\Models\Ball;
use App\Models\BallPlacement;
use Illuminate\Http\Request;

class BallPlacementController extends Controller
{
    public function index()
    {
        $balls = Ball::all();
        return view('ball-placements.index', compact('balls'));
    }

    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'ball_id' => 'required',
            'total_balls' => 'required',
        ]);
        BallPlacement::create($validatedData);

        return redirect()->back()->with('success', 'Ball placements saved successfully');
    }
}
