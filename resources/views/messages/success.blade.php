<!-- store.blade.php -->

@extends('layouts.app')

@section('content')
    <!-- Your HTML content goes here -->
    <div>
        <label for="secret_code">Secret Code:</label>
        <input type="text" id="secret_code" value="{{ session('secret_code') }}" readonly>
        <button onclick="copyToClipboard('{{ session('secret_code') }}')">Copy</button>
    </div>
    <div>
        <a href="{{ route('messages.read') }}" class="btn btn-primary">View Messages</a>
    </div>

    <script>
        function copyToClipboard(text) {
            var input = document.createElement('textarea');
            input.innerHTML = text;
            document.body.appendChild(input);
            input.select();
            document.execCommand('copy');
            document.body.removeChild(input);
            alert('Secret Code copied to clipboard!');
        }
    </script>
@endsection
