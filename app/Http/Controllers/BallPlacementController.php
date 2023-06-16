<?php

namespace App\Http\Controllers;

use App\Models\Ball;
use App\Models\Bucket;
use App\Models\BallPlacement;
use Illuminate\Http\Request;

class BallPlacementController extends Controller
{
    public function index()
    {
        $balls = Ball::all();

        $buckets = Bucket::all();
        $totalEmptyVolume = 0;
        if ($buckets) {
            foreach ($buckets as $bucket) {
                $emptyVolume = $bucket['bucket_total_volume'] - $bucket['bucket_filled_volume'];
                $totalEmptyVolume += $emptyVolume;
            }
        }
        return view('ball-placements.index', compact('balls', 'totalEmptyVolume', 'buckets'));
    }

    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'ball_id' => 'required',
            'total_balls' => 'required',
        ]);

        $bucketId = 1; // Replace with the desired bucket ID

        $ballDetails = Ball::select('ball_name', 'ball_volume')
            ->where('id', $validatedData['ball_id'])
            ->first();

        if ($ballDetails) {

            $ballVolume = $ballDetails->ball_volume;

            $buckets = Bucket::all();

            if ($buckets) {
                $totalEmptyVolume = 0;
                $totalBalls = $validatedData['total_balls'];
                $requestedVolume = $totalBalls * $ballVolume;

                foreach ($buckets as $bucket) {

                    $emptyVolume = $bucket['bucket_total_volume'] - $bucket['bucket_filled_volume'];
                    $totalEmptyVolume += $emptyVolume;
                }

                if($requestedVolume > $totalEmptyVolume) {

                    return redirect()->back()->with('error', 'We do not have enough space.');
                }

                foreach ($buckets as $bucket) {


                    $emptyVolume = $bucket['bucket_total_volume'] - $bucket['bucket_filled_volume'];
                    if (isset($emptyVolume) && ($emptyVolume > 0) && isset($ballVolume) && ($ballVolume > 0)) {
                        if($emptyVolume > $ballVolume) {

                            $ballPlacementData = array();
                            $filledBalls = 0;
                            if($requestedVolume <= $emptyVolume) {
                                $bucket['bucket_filled_volume'] += $requestedVolume;
                                $filledBalls = $requestedVolume;
                                $requestedVolume = 0;
                            } else {
                                $tBalls = intval($emptyVolume / $ballDetails->ball_volume);
                                $bucket['bucket_filled_volume'] += $tBalls * $ballDetails->ball_volume;
                                $requestedVolume = $requestedVolume - ($tBalls * $ballDetails->ball_volume);
                                $filledBalls = $tBalls * $ballDetails->ball_volume;
                            }
                            $ballPlacementData['ball_id'] = $validatedData['ball_id'];
                            $ballPlacementData['bucket_id'] = $bucket['id'];
                            $ballPlacementData['total_balls'] = $filledBalls / $ballDetails->ball_volume;
                            BallPlacement::create($ballPlacementData);
                            Bucket::where('id', $bucket['id'])->update(['bucket_filled_volume' => $bucket['bucket_filled_volume']]);
                            if($requestedVolume <= 0) {
                                break;
                            }
                        }
                    }
                }
            }
        }

//        return response()->json(['message' => 'OK'], 201);

        return redirect()->back()->with('success', 'Ball placements saved successfully');
    }
}
