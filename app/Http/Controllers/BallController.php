<?php

namespace App\Http\Controllers;

use App\Models\Bucket;
use Illuminate\Http\Request;
use App\Models\Ball;
use App\Models\BallPlacement;
use Illuminate\Support\Facades\DB;

class BallController extends Controller
{
    public function create()
    {
        DB::table('buckets')->update(['bucket_filled_volume' => 0]);
        DB::table('ball_placements')->truncate();
        return view('balls.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'ball_name' => 'required',
            'ball_volume' => 'required|numeric',
        ]);

        $existingBall = Ball::where('ball_name', $request->input('ball_name'))->first();

        if ($existingBall) {
            return redirect('/balls/create')->with('error', 'Ball name already exists.');
        }

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

        $existingBall = Ball::where('ball_name', $ball['ball_name'])
            ->where('id', '!=', $ball['id'])
            ->first();

        if ($existingBall) {
            return redirect()->route('balls.index')->with('error', 'Ball name already exists');
        }

        $ball = Ball::find($ball['id']);
        if (!$ball) {
            return redirect()->route('balls.index')->with('error', 'Ball not found');
        }

        BallPlacement::where('ball_id', $ball['id'])->delete();
        $ball->update($request->all());
        DB::table('buckets')->update(['bucket_filled_volume' => 0]);
        DB::table('ball_placements')->truncate();
        return redirect()->route('balls.index')->with('success', 'Ball updated successfully');
    }

    public function destroy(Ball $ball)
    {
        $ball->delete();
//        DB::table('buckets')->update(['bucket_filled_volume' => 0]);
        DB::table('ball_placements')->truncate();
        return redirect()->route('balls.index')->with('success', 'Ball deleted successfully');
    }
}
