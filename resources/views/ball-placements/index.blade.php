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
    <h1>Balls Placement</h1>
    @if(session('success'))
        <p class="success-message">{{ session('success') }}</p>
    @endif
    @if(session('error'))
        <p class="error-message">{{ session('error') }}</p>
    @endif

    <form method="POST" action="/place-balls">
        @csrf
        <div class="form-group row">

            <div class="col-6">
                <select class="form-control" id="ball_id" name="ball_id" required>
                    <option value="">-- Select Ball --</option>
                @foreach($balls as $ball)
                        <option value="{{$ball->id}}">{{$ball->ball_name}}</option>
                @endforeach
                </select>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <input type="number" min="1" required placeholder="Total Balls" class="form-control" id="total_balls" name="total_balls">
                </div>
            </div>
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>
</div>

<div class="container" style="margin-top: 50px !important;">
    <h1>Bucket Suggestions</h1>
    <h4>Total Empty Volume : {{$totalEmptyVolume}} cubic inches</h4>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th style="border:1px solid #dee2e6!important;">Ball Name</th>
            <th style="border:1px solid #dee2e6!important;">Possible Quantity</th>
        </tr>
        </thead>
        <tbody>
        @foreach($balls as $ball)
            <tr>
                <td style="border:1px solid #dee2e6!important;">{{$ball->ball_name}}</td>
                <td style="border:1px solid #dee2e6!important;">{{intval($totalEmptyVolume/$ball->ball_volume)}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <table>
        <thead>
        <tr>
            <th style="border:1px solid #dee2e6!important;">Bucket Name</th>
            <th style="border:1px solid #dee2e6!important;">Empty Volume</th>
            <th style="border:1px solid #dee2e6!important;">Suggested Balls</th>
        </tr>
        @foreach($buckets as $bucket)
            <tr>
                <td style="border:1px solid #dee2e6!important;">{{$bucket->bucket_name}}</td>
                <td style="border:1px solid #dee2e6!important;">{{$bucket->bucket_total_volume - $bucket->bucket_filled_volume}}</td>
                <td style="border:1px solid #dee2e6!important;">
                    @foreach($balls as $index => $ball)
                        @if(intval(($bucket->bucket_total_volume - $bucket->bucket_filled_volume) / $ball->ball_volume))
                        Place {{intval(($bucket->bucket_total_volume - $bucket->bucket_filled_volume) / $ball->ball_volume)}}  {{$ball->ball_name}} balls
                        {{count($balls) - $index > 1 ? 'or' : ''}}
                        @endif
                    @endforeach
                </td>
            </tr>
        @endforeach
    </table>
</div>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
