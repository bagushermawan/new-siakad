@extends('admin.layouts.master')
@section('title', 'Profile')
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Account Profile</h3>
                    <p class="text-subtitle text-muted">A page where users can change profile information</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                            <li class="breadcrumb-item">Account</li>
                            <li class="breadcrumb-item active" aria-current="page">Profile</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="row">
                <div class="col-12 col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-center align-items-center flex-column">
                                <div class="avatar avatar-2xl">
                                    <img src="{{ asset('compiled/jpg/2.jpg') }}" alt="Avatar">
                                </div>

                                <h3 class="mt-3">{{ ucfirst(auth()->user()->name) }}</h3>
                                <p class="text-small">{{ ucfirst(implode(', ', $roles->all())) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Profile Information</h5>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                Update your account's profile information and email address.
                            </p>
                        </div>
                        <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                            @csrf
                        </form>
                        <div class="card-body">
                            <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
                                @csrf
                                @method('patch')
                                <div class="form-group">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" name="name" id="name" class="form-control" required
                                        autofocus autocomplete value="{{ old('name', $user->name) }}">
                                </div>
                                <div class="form-group">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" name="username" id="username" class="form-control" required
                                        autocomplete value="{{ old('username', $user->username) }}">
                                </div>
                                <div class="form-group">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="text" name="email" id="email" class="form-control" required
                                        autocomplete value="{{ old('email', $user->email) }}">
                                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                                        <div>
                                            <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                                                {{ __('Your email address is unverified.') }}

                                                <button form="send-verification" class="btn btn-sm btn-outline-secondary">
                                                    {{ __('Click here to re-send the verification email.') }}
                                                </button>
                                            </p>

                                            @if (session('status') === 'verification-link-sent')
                                                <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                                                    {{ __('A new verification link has been sent to your email address.') }}
                                                </p>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </div>
                                @if (session('status') === 'profile-updated')
                                    <div class="alert alert-success alert-dismissible show fade">
                                        Saved
                                        <button type="button" class="btn- sm btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                @endif
                            </form>
                        </div>
                    </div>


                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Change Password</h5>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                Ensure your account is using a long, random password to stay secure.
                            </p>
                        </div>
                        <div class="card-body">
                            <form action="#" method="get">
                                <div class="form-group my-2">
                                    <label for="current_password" class="form-label">Current Password</label>
                                    <input type="password" name="current_password" id="current_password"
                                        class="form-control" placeholder="Enter your current password"
                                        value="1L0V3Indonesia">
                                </div>
                                <div class="form-group my-2">
                                    <label for="password" class="form-label">New Password</label>
                                    <input type="password" name="password" id="password" class="form-control"
                                        placeholder="Enter new password" value="">
                                </div>
                                <div class="form-group my-2">
                                    <label for="confirm_password" class="form-label">Confirm Password</label>
                                    <input type="password" name="confirm_password" id="confirm_password"
                                        class="form-control" placeholder="Enter confirm password" value="">
                                </div>

                                <div class="form-group my-2 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Delete Account</h5>
                        </div>
                        <div class="card-body">
                            <form action="#" method="get">
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                    Once your account is deleted, all of its resources and data will be permanently deleted.
                                    Before deleting your account, please download any data or information that you wish to
                                    retain.
                                </p>
                                <div class="form-group my-2 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-danger" id="btn-delete-account"
                                        disabled="">Delete</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
