<!-- resources/views/admin/dashboard.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="display-4 text-center mb-4">Admin Dashboard</h1>

    <div class="row">
        <!-- Manage Users Section -->
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Manage Users</h5>
                    <p class="card-text">Create, delete, or view users on the platform.</p>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-primary w-100">Manage Users</a>
                </div>
            </div>
        </div>

        <!-- View Itineraries Section -->
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">View Itineraries</h5>
                    <p class="card-text">View, edit, or delete itineraries created by users.</p>
                    <a href="{{ route('admin.itineraries.index') }}" class="btn btn-primary w-100">View Itineraries</a>
                </div>
            </div>
        </div>

       <!-- Send Notifications Section -->
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Send Notifications</h5>
                    <p class="card-text">Send notifications to all users of the platform.</p>
                    <a href="{{ route('admin.notifications.index') }}" class="btn btn-primary w-100">Send Notification</a>
                </div>
            </div>
        </div>

        <!-- Other Admin Functions Section -->
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Other Admin Functions</h5>
                    <p class="card-text">Access other features like managing destinations, or site content.</p>
                    <!-- You can add more options here -->
                    <a href="#" class="btn btn-primary w-100">Other Functions</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
