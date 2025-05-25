@extends('layouts.admin')
@section('content')
    <div class="row mb-4">
        <div class="col">
            <div class="card bg-primary text-white shadow">
                <div class="card-body">
                    Selamat datang, {{ Auth::user()->name }}! 👋
                </div>
            </div>
        </div>
    </div>
@endsection
