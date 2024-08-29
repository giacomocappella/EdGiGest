<h1>INSERIMENTO NUOVO TICKET</h1>
<div>
<form action="{{route('store.ticket')}}" method="POST">
    @csrf
    <label for="Cliente">Cliente: </label>
    <select name="Client_list" class="form-select">
        @foreach ($items as $item)
        <option value="{{$item['id']}}">{{$item['name']}}</option>
        @endforeach
    </select>
    </div>
    <div>
    <label for="Ticket_name">Nome Ticket: </label>
    <input type="text" name="Ticket_name" value="{{ old('Ticket_name') }}">
        @error('Ticket_name')
                <div style="color:red;">{{ $message }}</div>
        @enderror
    </div><br>
    <div>
    <button type="submit">Crea ticket e apri nuova attività</button>
    </div>
