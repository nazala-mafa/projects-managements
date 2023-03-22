@extends('layouts.app')

@section('content')
  <div class="container mt-5">
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

    <div class="card">
      <div class="card-header d-flex justify-content-between">
        <h4 class="mb-0">Manage Tasks</h4>
        <div>
          <button class="btn btn-primary btn-add">Add New Task</button>
        </div>
      </div>
      <div class="card-body">
        <table id="tasks-table" class="display" style="width:100%">
          <thead>
            <tr>
              <th>#</th>
              <th>User Assign</th>
              <th>Name</th>
              <th>Description</th>
              <th>Deadline</th>
              <td>Image</td>
              <td>Action</td>
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
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" rows="4" class="form-control"></textarea>
          </div>
          <div class="mb-3">
            <label for="deadline" class="form-label">Deadline</label>
            <input type="date" name="deadline" id="deadline" class="form-control">
          </div>
          <div class="mb-3">
            <label for="user_assign" class="form-label">User Assign</label>
            <select name="user_assign" id="user_assign" class="form-control">
              @foreach ($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label for="Image" class="form-label">Image</label>
            <input class="form-control" type="file" name="image" id="image">
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
