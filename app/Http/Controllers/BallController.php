<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ball;

class BallController extends Controller
{
    public function create()
    {
        return view('balls.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'ball_name' => 'required',
            'ball_volume' => 'required|numeric',
        ]);

        Ball::create($validatedData);

        return redirect('/balls/create')->with('success', 'Ball saved successfully.');
    }

    public function index()
    {
        $balls = Ball::all();
        return view('balls.index', compact('balls'));
    }
    public function edit(Ball $ball)
    {
        return view('balls.edit', compact('ball'));
    }

    public function update(Request $request, Ball $ball)
    {
        $ball->update($request->all());
        return redirect()->route('balls.index')->with('success', 'Ball updated successfully');
    }

    public function destroy(Ball $ball)
    {
        $ball->delete();
        return redirect()->route('balls.index')->with('success', 'Ball deleted successfully');
    }
}
