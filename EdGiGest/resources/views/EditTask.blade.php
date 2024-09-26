<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifica Attività</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .form-container {
            max-width: 600px;
            background-color: #fff;
            padding: 20px;
            margin: 0 auto;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        .form-group input, .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        .form-group input:focus, .form-group textarea:focus {
            outline: none;
            border-color: #4CAF50;
        }

        .error {
            color: red;
            font-size: 14px;
            margin-top: 5px;
        }

        .button-container {
            display: flex;
            justify-content: space-between;
        }

        .submit-btn, .cancel-btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            text-transform: uppercase;
            text-align: center;
        }

        .submit-btn:hover, .cancel-btn:hover {
            background-color: #45a049;
        }

        .cancel-btn {
            background-color: #f44336;
        }

        .cancel-btn:hover {
            background-color: #e53935;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h1>MODIFICA ATTIVITÀ</h1>
    <form action="{{ route('store.edit.task') }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="Task_Start">Inizio attività</label>
            <input type="datetime-local" id="Task_Start" name="Task_Start" value="{{ $task['timeInterval']['start'] }}">
            @error('Task_Start')
            <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="Task_End">Fine attività</label>
            <input type="datetime-local" id="Task_End" name="Task_End" value="{{ $task['timeInterval']['end'] }}">
            @error('Task_End')
            <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="Description">Descrizione attività</label>
            <textarea id="Description" name="Description">{{ $task['description']}}</textarea>
            @error('Description')
            <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="button-container">
            <input type=hidden name="idticket" value="{{ $idticket }}">
            <input type=hidden name="idtask" value="{{ $task['id'] }}">
            <button type="submit" class="submit-btn">Conferma</button>
            <a href="{{ route('get.tasks') }}" class="cancel-btn">Torna indietro</a>
        </div>
    </form>
</div>

</body>
</html>
