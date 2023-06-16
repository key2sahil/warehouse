<!DOCTYPE html>
<html>
<head>
    <title>Edit Ball</title>
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
    <h1>Edit Ball</h1>
    <form method="POST" action="{{ route('balls.update', $ball->id) }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="ball_name">Ball Name:</label>
            <input type="text" class="form-control" name="ball_name" disabled value="{{ $ball->ball_name }}">
        </div>

        <div class="form-group">
            <label for="ball_volume">Total Volume:</label>
            <input type="text" class="form-control" name="ball_volume" value="{{ $ball->ball_volume }}">
        </div>

        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
