@extends('layouts.app')

@section('content')
  <div class="row justify-content-center">
    <div class="col-12 col-md-8 col-xl-6 mt-5">
      <div class="card">
        <div class="card-header">
          <h4 class="mb-0">Add New User</h4>
        </div>
        <div class="card-body">
          <form action="{{ route('users.store') }}" method="post">
            @csrf
            <div class="mb-3">
              <label for="name" class="form-label">Name</label>
              <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                value="{{ old('name') }}" required autofocus>

              @error('name')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>
            <div class="mb-3">
              <label for="name" class="form-label">Email</label>
              <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                name="email" value="{{ old('email') }}" required>

              @error('email')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input type="text" class="form-control @error('password') is-invalid @enderror" id="password"
                name="password" value="{{ old('password') }}" required>

              @error('password')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>

            <div class="mb-3">
              <button type="submit" class="btn w-100 btn-primary">Submit</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
