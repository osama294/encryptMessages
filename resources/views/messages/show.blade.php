@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Retrieved Messages</h1>
    @if ($messages->isEmpty())
        <p>No messages found.</p>
    @else
        <ul>
            @foreach ($messages as $message)
                <li>{{ $message }}</li>
            @endforeach
        </ul>
    @endif
</div>
@endsection
