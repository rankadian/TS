@php
    $breadcrumb = (object) [
        'title' => 'Dashboard',
        'list' => ['Home', 'Dashboard']
    ];
    $activeMenu = 'dashboard';
@endphp

@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h5>Welcome User, {{ auth()->user()->nama }}</h5>
                <p>This is your dashboard.</p>
            </div>
        </div>
    </div>
@endsection