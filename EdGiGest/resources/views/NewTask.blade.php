<h1>INSERIMENTO NUOVO TASK</h1>
<div>
<form action="{{route('store.task')}}" method="POST">
    @csrf
    <label for="Task_name">Nome Attività: </label>
    <input type="text" name="Task_name" value="{{ old('Task_name') }}">
        @error('Task_name')
                <div style="color:red;">{{ $message }}</div>
        @enderror
    </div><br>
    <div>
    <button type="submit">Crea attività e aggiungi sotto-attività</button>
    </div>