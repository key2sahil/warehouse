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
        $data = $request->input('ball');
        foreach ($data as $ballId => $totalBalls) {
            if ($totalBalls !== null) {
                BallPlacement::create([
                    'ball_id' => $ballId,
                    'total_balls' => $totalBalls,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Ball placements saved successfully');
    }
}
