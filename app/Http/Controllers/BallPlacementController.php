<?php

namespace App\Http\Controllers;

use App\Models\Ball;
use App\Models\Bucket;
use App\Models\BallPlacement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BallPlacementController extends Controller
{
    public function index()
    {
        $balls = Ball::all();
        $buckets = Bucket::all();

        $query = DB::table('ball_placements')
            ->select('buckets.bucket_name AS bucket_name', 'balls.ball_name AS ball_name', 'ball_placements.total_balls AS total_balls')
            ->leftJoin('buckets', 'buckets.id', '=', 'ball_placements.bucket_id')
            ->leftJoin('balls', 'balls.id', '=', 'ball_placements.ball_id')
            ->orderBy('buckets.bucket_name')
            ->orderBy('balls.ball_name')
            ->get();

        $data = json_decode($query, true);

        $ballPlacements = [];

        foreach ($data as $item) {
            $bucketName = $item['bucket_name'];
            $ballName = $item['ball_name'];
            $totalBalls = $item['total_balls'];

            if (!isset($ballPlacements[$bucketName])) {
                $ballPlacements[$bucketName] = [];
            }

            if (!isset($ballPlacements[$bucketName][$ballName])) {
                $ballPlacements[$bucketName][$ballName] = 0;
            }

            $ballPlacements[$bucketName][$ballName] += $totalBalls;
        }

//        $ballPlacements = json_encode($ballPlacements);

        return view('ball-placements.index', compact('balls', 'ballPlacements', 'buckets'));
    }

    public function store(Request $request)
    {
        $isBallPlaced = 0;
        $validatedData = $request->validate([
            'total_balls' => 'required',
        ]);
        $totalBallArray = $validatedData['total_balls'];
        foreach ($totalBallArray as $id => $totalBalls) {

            if($totalBalls > 0) {
                $isBallPlaced = $this->ballPlacement($id, $totalBalls);
            }
        }
        if($isBallPlaced) {
            return redirect()->back()->with('success', 'Ball placements saved successfully');
        }
        return redirect()->back()->with('error', 'There is no enough space to place balls.');
    }

    public function ballPlacement($ball_id, $totalBalls) {

        $isBallPlaced = 0;
        $ballDetails = Ball::select('ball_name', 'ball_volume')
            ->where('id', $ball_id)
            ->first();

        if ($ballDetails) {

            $ballVolume = $ballDetails->ball_volume;

            $buckets = Bucket::all();

            if ($buckets) {

                $requestedVolume = (float)$totalBalls * (float)$ballVolume;

                foreach ($buckets as $bucket) {

                    $emptyVolume = $bucket['bucket_total_volume'] - $bucket['bucket_filled_volume'];
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
                            $ballPlacementData['ball_id'] = $ball_id;
                            $ballPlacementData['bucket_id'] = $bucket['id'];
                            $ballPlacementData['total_balls'] = $filledBalls / $ballDetails->ball_volume;
                            BallPlacement::create($ballPlacementData);
                            Bucket::where('id', $bucket['id'])->update(['bucket_filled_volume' => $bucket['bucket_filled_volume']]);
                            $isBallPlaced = 1;
                            if($requestedVolume <= 0) {
                                break;
                            }
                        }
                    }
                }
            }
        }
        return $isBallPlaced;
    }
}
