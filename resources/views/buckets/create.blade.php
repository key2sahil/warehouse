<!DOCTYPE html>
<html>
<head>
    <title>Create Bucket</title>
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
    <h2><a href="{{ route('buckets.index') }}">List of Buckets</a></h2>
    <h1>Create Bucket</h1>
    @if(session('success'))
        <p class="success-message">{{ session('success') }}</p>
    @endif
    @if(session('error'))
        <p class="error-message">{{ session('error') }}</p>
    @endif

    <form method="POST" action="/buckets">
        @csrf

        <div class="form-group">
            <label for="bucket_name">Bucket Name:</label>
            <input type="text" class="form-control" id="bucket_name" name="bucket_name" required>
        </div>

        <div class="form-group">
            <label for="bucket_total_volume">Volume (in inches):</label>
            <input type="number" step="0.01" class="form-control" id="bucket_total_volume" name="bucket_total_volume" required>
        </div>

        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
