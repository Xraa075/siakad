@extends('layouts.admin')
@section('content')
<div class="container mt-4">
    <h3 class="mb-3">Edit Departemen: <span class="fw-normal">{{ $departemen->nama_departemen }}</span></h3>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.departemen.update', $departemen->id) }}" method="POST">
                @csrf
                @method('PUT')
                @include('admin.departemen.partials.form', [
                    'submitButtonText' => 'Update Data',
                    'departemen' => $departemen,
                ])
            </form>
        </div>
    </div>
</div>
@endsection
