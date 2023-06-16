<!DOCTYPE html>
<html>
<head>
    <title>Create Ball</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        body {
            padding: 20px;
        } form label {
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
    <h2><a href="{{ route('balls.index') }}">List of Balls</a></h2>
    <h1>Create Ball</h1>
    @if(session('success'))
        <p class="success-message">{{ session('success') }}</p>
    @endif
    @if(session('error'))
        <p class="error-message">{{ session('error') }}</p>
    @endif

    <form method="POST" action="/balls">
        @csrf

        <div class="form-group">
            <label for="ball_name">Ball Name:</label>
            <input type="text" class="form-control" id="ball_name" name="ball_name" required>
        </div>

        <div class="form-group">
            <label for="ball_volume">Volume (in cubic inches):</label>
            <input type="number" step="0.01" class="form-control" id="ball_volume" name="ball_volume" required>
        </div>
        <a type="button" class="btn btn-danger" href="{{ route('balls.index') }}">Cancel</a>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
