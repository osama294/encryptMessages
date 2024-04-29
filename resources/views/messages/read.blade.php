@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Enter Your Name & Secret Code to Retrieve Messages</h1>
    <form method="POST" action="{{ route('messages.retrieve') }}">
        @csrf
        <div class="form-group">
            <Re for="identifier">Name:</Re>
            <input type="text" class="form-control" id="identifier" name="identifier" required>
        </div>
        <div class="form-group">
            <label for="identifier">Secret Code:</label>
            <input type="text" class="form-control" id="secretCode" name="secretCode" required>
        </div>
        <button type="submit" class="btn btn-primary">Retrieve Messages</button>
    </form>
</div>
@endsection
