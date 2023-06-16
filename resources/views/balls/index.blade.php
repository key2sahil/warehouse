<div class="container">
    <div class="row">
        <div class="col"><h2><a href="/">Home</a></h2></div>
        <div class="col"><h2><a href="{{ route('balls.create') }}">Add New Ball</a></h2></div>
    </div>

    <h1>List of Balls</h1>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th style="border:1px solid #dee2e6!important;">Ball Name</th>
                <th style="border:1px solid #dee2e6!important;">Volume (in cubic inches)</th>
                <th style="border:1px solid #dee2e6!important;">Actions</th>
            </tr>
            </thead>
            <tbody>
            @if(count($balls))
                @foreach($balls as $ball)
                    <tr>
                        <td style="border:1px solid #dee2e6!important;">{{ $ball->ball_name }}</td>
                        <td style="border:1px solid #dee2e6!important;">{{ $ball->ball_volume ? $ball->ball_volume : 0 }}</td>
                        <td style="border:1px solid #dee2e6!important;">
                            <a href="{{ route('balls.edit', $ball->id) }}" class="btn btn-primary">Edit</a>
                            <form method="POST" action="{{ route('balls.destroy', $ball->id) }}" style="display:inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="3" class="border text-center">No balls found</td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>
</div>
