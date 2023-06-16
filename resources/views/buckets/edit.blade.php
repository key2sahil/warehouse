<!DOCTYPE html>
<html>
<head>
    <title>Edit Bucket</title>
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
    <h1>Edit Bucket</h1>
    <form method="POST" action="{{ route('buckets.update', $bucket->id) }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="bucket_name">Bucket Name:</label>
            <input type="text" class="form-control" name="bucket_name" disabled value="{{ $bucket->bucket_name }}">
        </div>

        <div class="form-group">
            <label for="bucket_total_volume">Total Volume:</label>
            <input type="text" class="form-control" name="bucket_total_volume" value="{{ $bucket->bucket_total_volume }}">
        </div>

        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
