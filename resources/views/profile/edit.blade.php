@extends('admin.layouts.master')
@section('title', 'Profile')
@push('page-css')
    <link rel="stylesheet" href="{{ asset('/extensions/filepond/filepond.css') }}">
    <link rel="stylesheet" href="{{ asset('/extensions/filepond-plugin-image-preview/filepond-plugin-image-preview.css') }}">
@endpush
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
                                    @if (auth()->user()->foto_user)
                                        <img src="{{ asset('storage/' . auth()->user()->foto_user) }}" alt="Avatar">
                                    @else
                                        <img src="{{ asset('compiled/jpg/1.jpg') }}" alt="Avatar">
                                    @endif
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
                            <form method="post" action="{{ route('admin.user.update', ['id' => $user->id]) }}"
                                class="mt-6 space-y-6" enctype="multipart/form-data">
                                @csrf
                                {{ method_field('put') }}
                                <div class="form-group">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" name="name" id="name" class="form-control" required
                                        autofocus value="{{ $user->name }}">
                                </div>
                                <div class="form-group">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" name="username" id="username" class="form-control" required
                                        value="{{ $user->username }}">
                                </div>
                                <div class="form-group">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="text" name="email" id="email" class="form-control" required
                                        value="{{ $user->email }}">
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
                                <div class="form-groupp">
                                    <p class="card-text">Foto.
                                    </p>
                                    <input type="file" class="image-exif-filepond" name="foto_user">
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
                            <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
                                @csrf
                                @method('put')
                                <div class="form-group my-2">
                                    <label for="current_password" class="form-label">Current Password</label>
                                    <input type="password" name="current_password" id="current_password"
                                        class="form-control" placeholder="Enter your current password" value="">
                                    <div style="color:rgb(248 113 113);">
                                        @if ($errors->updatePassword->has('current_password'))
                                            {{ $errors->updatePassword->first('current_password') }}
                                        @endif
                                    </div>
                                    <div class="form-group my-2">
                                        <label for="password" class="form-label">New Password</label>
                                        <input type="password" name="password" id="password" class="form-control"
                                            placeholder="Enter new password" value="">
                                        <div style="color:rgb(248 113 113);">
                                            @if ($errors->updatePassword->has('password'))
                                                {{ $errors->updatePassword->first('password') }}
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group my-2">
                                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                                        <input type="password" name="password_confirmation" id="password_confirmation"
                                            class="form-control" placeholder="Enter confirm password" value="">
                                        <div style="color:rgb(248 113 113);">
                                            @if ($errors->updatePassword->has('password_confirmation'))
                                                {{ $errors->updatePassword->first('password_confirmation') }}
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                    </div>
                                    @if (session('status') === 'password-updated')
                                        <div class="alert alert-success alert-dismissible show fade">
                                            Saved
                                            <button type="button" class="btn- sm btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>
                                    @endif
                            </form>
                        </div>
                    </div>
                </div>




                <div class="card">
                    <div class="card-header">

                        <h5 class="card-title">
                            {{ __('Delete Account') }}
                        </h5>

                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
                        </p>

                        <div class="form-group">
                            <button class="btn btn-danger" onclick="openConfirmUserDeletionModal()">DELETE
                                ACCOUNT</button>
                        </div>
                        <div id="confirm-user-deletion" class="modal fade" tabindex="-1">
                            <div class="modal-dialog">
                                <form method="post" action="{{ route('profile.destroy') }}" class="modal-content p-4">
                                    @csrf
                                    @method('delete')

                                    <h2 class="card-title">
                                        {{ __('Are you sure you want to delete your account?') }}
                                    </h2>

                                    <p class="mt-1 text-sm text-muted">
                                        {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                                    </p>

                                    <div class="mt-3">
                                        <label for="password"
                                            class="form-label visually-hidden">{{ __('Password') }}</label>
                                        <input id="password" name="password" type="password" class="form-control"
                                            placeholder="{{ __('Password') }}" />

                                        <div style="color:rgb(248 113 113);">
                                            @if ($errors->userDeletion->has('password'))
                                                <script>
                                                    // Buka modal secara otomatis jika ada kesalahan password
                                                    document.addEventListener("DOMContentLoaded", function() {
                                                        openConfirmUserDeletionModal();
                                                    });
                                                </script>
                                                {{ $errors->userDeletion->first('password') }}
                                            @endif
                                        </div>
                                    </div>

                                    <div class="mt-4 d-flex justify-content-end">
                                        <button type="button" class="btn btn-secondary"
                                            onclick="closeConfirmUserDeletionModal()">{{ __('Cancel') }}</button>
                                        <button type="submit"
                                            class="btn btn-danger ms-3">{{ __('Delete Account') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>

                <script>
                    function openConfirmUserDeletionModal() {
                        var modal = new bootstrap.Modal(document.getElementById('confirm-user-deletion'));
                        modal.show();
                    }

                    function closeConfirmUserDeletionModal() {
                        var modal = new bootstrap.Modal(document.getElementById('confirm-user-deletion'));
                        modal.hide();
                    }
                </script>

            </div>
        </section>
    </div>
@endsection
@push('page-script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var confirmUserDeletionModal = new bootstrap.Modal(document.getElementById('confirm-user-deletion'));

            function openConfirmUserDeletionModal() {
                confirmUserDeletionModal.show();
            }

            function closeConfirmUserDeletionModal() {
                confirmUserDeletionModal.hide();
            }

            window.openConfirmUserDeletionModal = openConfirmUserDeletionModal;
            window.closeConfirmUserDeletionModal = closeConfirmUserDeletionModal;
        });
    </script>
    <script src="{{ asset('/extensions/filepond-plugin-file-validate-size/filepond-plugin-file-validate-size.min.js') }}">
    </script>
    <script src="{{ asset('/extensions/filepond-plugin-file-validate-type/filepond-plugin-file-validate-type.min.js') }}">
    </script>
    <script src="{{ asset('/extensions/filepond-plugin-image-crop/filepond-plugin-image-crop.min.js') }}"></script>
    <script
        src="{{ asset('/extensions/filepond-plugin-image-exif-orientation/filepond-plugin-image-exif-orientation.min.js') }}">
    </script>
    <script src="{{ asset('/extensions/filepond-plugin-image-filter/filepond-plugin-image-filter.min.js') }}"></script>
    <script src="{{ asset('/extensions/filepond-plugin-image-preview/filepond-plugin-image-preview.min.js') }}"></script>
    <script src="{{ asset('/extensions/filepond-plugin-image-resize/filepond-plugin-image-resize.min.js') }}"></script>
    <script src="{{ asset('/extensions/filepond/filepond.js') }}"></script>
    {{-- <script src="{{ asset('/extensions/toastify-js/src/toastify.js') }}"></script> --}}
    <script src="{{ asset('/static/js/pages/filepond.js') }}"></script>
@endpush
