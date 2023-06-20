<?php

namespace App\Http\Controllers;

use App\Models\BallPlacement;
use Illuminate\Http\Request;
use App\Models\Bucket;
use Illuminate\Support\Facades\DB;

class BucketController extends Controller
{
    //
    public function create()
    {
        DB::table('buckets')->update(['bucket_filled_volume' => 0]);
        DB::table('ball_placements')->truncate();
        return view('buckets.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'bucket_name' => 'required',
            'bucket_total_volume' => 'required|numeric'
        ]);

        $existingBucket = Bucket::where('bucket_name', $request->input('bucket_name'))->first();

        if ($existingBucket) {
            return redirect('/buckets/create')->with('error', 'Bucket name already exists.');
        }


        Bucket::create($validatedData);

        return redirect('/buckets/create')->with('success', 'Bucket saved successfully.');

    }

    public function index()
    {
        $buckets = Bucket::all();
        return view('buckets.index', compact('buckets'));
    }
    public function edit(Bucket $bucket)
    {
        return view('buckets.edit', compact('bucket'));
    }

    public function update(Request $request, Bucket $bucket)
    {

        $existingBucket = Bucket::where('bucket_name', $request->input('bucket_name'))
            ->where('id', '!=', $request->input('id'))
            ->first();

        if ($existingBucket) {
            return redirect()->route('buckets.index')->with('error', 'Bucket name already exists');
        }

        $bucketData = Bucket::find($bucket['id']);
        if (!$bucketData) {
            return redirect()->route('buckets.index')->with('error', 'Bucket not found');
        }
        $bucket->update(['bucket_total_volume' => $request['bucket_total_volume']]);
        DB::table('buckets')->update(['bucket_filled_volume' => 0]);
        DB::table('ball_placements')->truncate();
        return redirect()->route('buckets.index')->with('success', 'Bucket updated successfully');
    }

    public function destroy(Bucket $bucket)
    {
        $bucket->delete();
        DB::table('buckets')->update(['bucket_filled_volume' => 0]);
        DB::table('ball_placements')->truncate();
        return redirect()->route('buckets.index')->with('success', 'Bucket deleted successfully');
    }
}
