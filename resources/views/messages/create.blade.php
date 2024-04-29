@extends('layouts.app')

@section('content')
    <h2>Send a New Message</h2>
    <form action="{{ url('/messages') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="recipient">Recipient Name:</label>
            <input type="text" class="form-control" id="recipient" name="recipient" required>
        </div>
        <div class="form-group">
            <label for="recipient_identifier">Recipient Identifier:</label>
            <input type="text" class="form-control" id="recipient_identifier" name="recipient_identifier" required>
        </div>

        <div class="form-group">
            <label for="message">Message:</label>
            <textarea class="form-control" id="message" name="message" required></textarea>
        </div>
        <div class="form-group">
            <label for="expiryDays">Expire After (minutes):</label>
            <input type="number" class="form-control" id="expiryMinutes" name="expiryMinutes" required>
        </div>


        <button type="submit" class="btn btn-primary">Send Message</button>
    </form>
@endsection
