<!DOCTYPE html>
<html>
<head>
    <title>Balls Placement</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        body {
            padding: 20px;
        }

        form label {
            font-weight: bold;
        }

        .success-message {
            color: green;
        }

        .error-message {
            color: red;
        }
    </style>
</head>
<body>
<div class="container">
    <h2><a href="/">Home</a></h2>
    <h1>Bucket Suggestion</h1>
    @if(session('success'))
        <p class="success-message">{{ session('success') }}</p>
    @endif
    @if(session('error'))
        <p class="error-message">{{ session('error') }}</p>
    @endif

    <form method="POST" action="/place-balls" style="padding: 10px !important;">
        @csrf
        <div class="form-group row">

            @foreach($balls as $ball)
                <div class="col-6">
                    <div class="form-group" id="{{$ball->ball_name}}" name="{{$ball->ball_name}}">
                        {{$ball->ball_name}}
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <input type="number" min="0" required placeholder="Ball Quantity" class="form-control" id="total_balls[{{$ball->id}}]" name="total_balls[{{$ball->id}}]" value="0">
                    </div>
                </div>
            @endforeach
        </div>
        <div class="col-12" style="text-align: center !important;">
            <a type="button" class="btn btn-danger" href="/">Cancel</a>
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>
</div>

{{--{{$ballPlacements}}--}}

<div class="container" style="margin-top: 50px !important;">
    <table>
        <thead>
        <tr>
            <th style="border:1px solid #dee2e6!important; padding:2px !important; text-align: center !important;" colspan="2">RESULT</th>
        <tr>
            <th style="border:1px solid #dee2e6!important; padding:2px !important;">Bucket Name</th>
            <th style="border:1px solid #dee2e6!important; padding:2px !important;">Balls Placed</th>
        </tr>
        </thead>
        <tbody>
        @if($ballPlacements)
            @foreach ($ballPlacements as $bucketName => $ballSums)
                <tr>
                    <td style="border:1px solid #dee2e6!important; padding:2px !important;">{{ $bucketName }}</td>
                    <td style="border:1px solid #dee2e6!important; padding:2px !important;">
                    @foreach ($ballSums as $ballName => $totalBalls)
                        {{ $totalBalls }} {{ $ballName }} balls
                            @unless($loop->last)
                                AND
                            @endunless
                    @endforeach
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td style="border:1px solid #dee2e6!important; text-align: center !important; padding:2px !important;" colspan="2">No Data Found</td>
            </tr>
        @endif
        </tbody>
    </table>
</div>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
