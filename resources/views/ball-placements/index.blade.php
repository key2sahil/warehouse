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
    </style>
</head>
<body>
<div class="container">
    <h2><a href="/">Home</a></h2>
    <h1>Balls Placement</h1>

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
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
