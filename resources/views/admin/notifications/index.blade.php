@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Send Notification to All Users</h1>

    <form action="{{ route('admin.sendNotification') }}" method="POST">
        @csrf

        <!-- Notification Title -->
        <div class="mb-4">
            <label for="title" class="block text-lg font-medium text-gray-700">Notification Title</label>
            <input type="text" name="title" id="title" class="form-control mt-1 block w-full" required>
        </div>

        <!-- Notification Message -->
        <div class="mb-4">
            <label for="message" class="block text-lg font-medium text-gray-700">Notification Message</label>
            <textarea name="message" id="message" rows="5" class="form-control mt-1 block w-full" required></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Send Notification</button>
    </form>
</div>
@endsection
