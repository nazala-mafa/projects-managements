@extends('layouts.app')

@section('content')
  <div class="d-flex justify-content-end">
    <div class="toast align-items-center text-white border-0 mb-3" role="alert" aria-live="assertive" id="toast"
      aria-atomic="true">
      <div class="d-flex">
        <div class="toast-body"></div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
          aria-label="Close"></button>
      </div>
    </div>
  </div>

  <div class="container">

    <div class="card">
      <div class="card-header d-flex justify-content-between">
        <h4 class="mb-0">Manage Users</h4>
        <div>
          <button class="btn btn-primary btn-add">Add New User</button>
        </div>
      </div>
      <div class="card-body">
        <table id="users-table" class="display" style="width:100%">
          <thead>
            <tr>
              <th>#</th>
              <th>Name</th>
              <th>Email</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>

  </div>

  <div class="modal" tabindex="-1" id="modal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id" id="id">
          <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input class="form-control" type="text" name="name" id="name">
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input class="form-control" type="email" name="email" id="email">
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input class="form-control" type="password" name="password" id="password">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary btn-submit">Submit</button>
        </div>
      </div>
    </div>
  </div>
@endsection
