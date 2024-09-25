<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Activity</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}"> <!-- Assicurati che app.css includa il CSS fornito -->
    <style>
        .form-container {
            background-color: var(--color-white);
            padding: var(--card-padding);
            border-radius: var(--card-border-radius);
            box-shadow: var(--box-shadow);
            width: 100%;
            max-width: 600px;
            margin: 2rem auto;
        }

        .form-title {
            font-size: 1.4rem;
            font-weight: 600;
            margin-bottom: 1.2rem;
            text-align: center;
            color: var(--color-dark);
        }

        .form-group {
            margin-bottom: 1.2rem;
        }

        .form-label {
            display: block;
            font-weight: 500;
            margin-bottom: 0.6rem;
            color: var(--color-dark-variant);
        }

        .form-input, .form-textarea {
            width: 100%;
            padding: 0.8rem;
            border-radius: var(--border-radius-1);
            border: 1px solid var(--color-light);
            font-family: 'Poppins', sans-serif;
            color: var(--color-dark);
            background-color: var(--color-background);
        }

        .form-input:focus, .form-textarea:focus {
            border-color: var(--color-primary);
        }

        .form-textarea {
            height: 150px;
            resize: none;
        }

        .form-button {
            display: block;
            width: 100%;
            padding: 0.8rem;
            font-size: 1rem;
            font-weight: 600;
            color: var(--color-white);
            background-color: var(--color-primary);
            border: none;
            border-radius: var(--border-radius-2);
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .form-button:hover {
            background-color: var(--color-danger);
        }

    </style>
</head>
<body>
    <div class="form-container">
        <h1 class="form-title">Create New Activity</h1>
        <form action="{{ route('store.task') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="start_datetime" class="form-label">Start Date & Time</label>
                <input type="datetime-local" id="start_datetime" name="start_datetime" class="form-input" required>
            </div>

            <div class="form-group">
                <label for="end_datetime" class="form-label">End Date & Time</label>
                <input type="datetime-local" id="end_datetime" name="end_datetime" class="form-input" required>
            </div>

            <div class="form-group">
                <label for="description" class="form-label">Description</label>
                <textarea id="description" name="description" class="form-textarea" required></textarea>
            </div>

            <button type="submit" class="form-button">Submit</button>
        </form>
    </div>
</body>
</html>
