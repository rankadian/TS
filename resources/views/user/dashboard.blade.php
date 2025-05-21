@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Dashboard User</h1>
    <p>Halo, {{ Auth::user()->name }}!</p>
</div>
@endsection
