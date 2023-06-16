<div class="container">
    <div class="row">
        <div class="col"><h2><a href="/">Home</a></h2></div>
        <div class="col"><h2><a href="{{ route('buckets.create') }}">Add New Bucket</a></h2></div>
    </div>

    <h1>List of Buckets</h1>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th style="border:1px solid #dee2e6!important;">Bucket Name</th>
                <th style="border:1px solid #dee2e6!important;">Total Volume (in inches)</th>
                <th style="border:1px solid #dee2e6!important;">Filled Volume (in inches)</th>
                <th style="border:1px solid #dee2e6!important;">Empty Volume (in inches)</th>
                <th style="border:1px solid #dee2e6!important;">Actions</th>
            </tr>
            </thead>
            <tbody>
            @if(count($buckets))
                @foreach($buckets as $bucket)
                    <tr>
                        <td style="border:1px solid #dee2e6!important;">{{ $bucket->bucket_name }}</td>
                        <td style="border:1px solid #dee2e6!important;">{{ $bucket->bucket_total_volume ? $bucket->bucket_total_volume : 0 }}</td>
                        <td style="border:1px solid #dee2e6!important;">{{ $bucket->bucket_filled_volume ? $bucket->bucket_filled_volume : 0 }}</td>
                        <td style="border:1px solid #dee2e6!important;">{{ $bucket->bucket_total_volume - (isset($bucket->bucket_filled_volume) ? $bucket->bucket_filled_volume : 0) }}</td>
                        <td style="border:1px solid #dee2e6!important;">
                            <a href="{{ route('buckets.edit', $bucket->id) }}" class="btn btn-primary">Edit</a>
                            <form method="POST" action="{{ route('buckets.destroy', $bucket->id) }}" style="display:inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="5" class="border text-center">No buckets found</td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>
</div>
