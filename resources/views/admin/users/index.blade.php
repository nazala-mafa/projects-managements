@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="card">
      <div class="card-header d-flex justify-content-between">
        <h4 class="mb-0">Manage Users</h4>
        <div>
          <a href="{{ route('users.create') }}" class="btn btn-primary">Add User</a>
        </div>
      </div>
      <div class="card-body">
        {{ $dataTable->table() }}
      </div>
    </div>
  </div>
@endsection

@push('scripts')
  {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush
