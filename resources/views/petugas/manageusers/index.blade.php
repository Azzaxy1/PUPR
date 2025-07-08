@extends('layouts.admin')

@section('admin-content')

<div class="container-fluid py-4">
  <div class="card shadow-sm border-0">
    <div class="card-header d-flex justify-content-between align-items-center bg-light">
      <h5 class="mb-0">Daftar Pengguna</h5>
      <a href="{{ route('petugas.users.create') }}" class="btn btn-primary btn-sm">
        <i class="fas fa-user-plus me-1"></i> Tambah Pengguna
      </a>
    </div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover mb-0">
          <thead class="table-light">
            <tr>
              <th>#</th>
              <th>Nama</th>
              <th>Email</th>
              <th>Role</th>
              <th>Status</th>
              <th class="text-center">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach($users as $i => $user)
            <tr>
              <td>{{ $users->firstItem() + $i }}</td>
              <td>{{ $user->name }}</td>
              <td>{{ $user->email }}</td>
              <td>{{ $user->role->title }}</td>
              <td>
                @if($user->is_active)
                  <span class="badge bg-success">Aktif</span>
                @else
                  <span class="badge bg-secondary">Non-aktif</span>
                @endif
              </td>
              <td class="text-center">
                <a href="{{ route('petugas.users.edit',$user->id) }}" class="btn btn-sm btn-outline-primary me-1">
                  <i class="fas fa-edit"></i>
                </a>
                <form action="{{ route('petugas.users.destroy',$user->id) }}" method="POST" class="d-inline">
                  @csrf @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin hapus pengguna?')">
                    <i class="fas fa-trash"></i>
                  </button>
                </form>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
    <div class="card-footer bg-white">
      {{ $users->links() }}
    </div>
  </div>
</div>
@endsection
