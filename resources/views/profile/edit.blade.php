@extends('layouts.app')

@section('header')
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profil') }}
        </h2>
        <div class="hidden sm:flex items-center space-x-4">
            <a href="#update-profile" class="px-3 py-2 text-sm font-medium text-white bg-primary rounded-lg hover:bg-primary-dark">
                Perbarui Profil
            </a>
            <a href="#update-password" class="px-3 py-2 text-sm font-medium text-white bg-primary rounded-lg hover:bg-primary-dark">
                Perbarui Password
            </a>
            <a href="#delete-account" class="px-3 py-2 text-sm font-medium text-white bg-danger rounded-lg hover:bg-danger-dark">
                Hapus Akun
            </a>
        </div>
    </div>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div id="update-profile" class="p-4 sm:p-8 bg-background-alt shadow-xl sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div id="update-password" class="p-4 sm:p-8 bg-background-alt shadow-xl sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div id="delete-account" class="p-4 sm:p-8 bg-background-alt shadow-xl sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
@endsection