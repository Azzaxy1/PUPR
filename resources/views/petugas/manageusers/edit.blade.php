@extends('layouts.admin')

@section('admin-content')

<div class="container-fluid py-4">
  <div class="row justify-content-center">
    <div class="col-lg-6">
      <div class="card shadow-sm border-0">
        <div class="card-header bg-light">
          <h5 class="mb-0">Form Edit Pengguna</h5>
        </div>
        <div class="card-body">
          @if($errors->any())
            <div class="alert alert-danger">
              <ul class="mb-0">
                @foreach($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif
          <form action="{{ route('petugas.users.update', $user->id) }}" method="POST">
            @csrf @method('PUT')
            <div class="mb-3">
              <label class="form-label">Nama</label>
              <input type="text" name="name" class="form-control" value="{{ old('name',$user->name) }}" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Email</label>
              <input type="email" name="email" class="form-control" value="{{ old('email',$user->email) }}" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Role</label>
              <select name="m_role_tab_id" class="form-select" required>
                @foreach(\App\Models\MRoleTab::all() as $role)
                  <option value="{{ $role->id }}" {{ old('m_role_tab_id',$user->m_role_tab_id)==$role->id?'selected':'' }}>{{ $role->title }}</option>
                @endforeach
              </select>
            </div>
            <div class="mb-3">
              <label class="form-label">Password Baru (opsional)</label>
              <input type="password" name="password" class="form-control">
            </div>
            <div class="mb-3">
              <label class="form-label">Konfirmasi Password</label>
              <input type="password" name="password_confirmation" class="form-control">
            </div>
            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label">No. Identitas</label>
                <input type="text" name="number_identification" class="form-control" value="{{ old('number_identification',$user->details->number_identification) }}" required>
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label">No. Telepon</label>
                <input type="text" name="number_phone" class="form-control" value="{{ old('number_phone',$user->details->number_phone) }}" required>
              </div>
              <div class="col-12 mb-3">
                <label class="form-label">Alamat</label>
                <textarea name="address" class="form-control" rows="2" required>{{ old('address',$user->details->address) }}</textarea>
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label">Pekerjaan</label>
                <input type="text" name="working" class="form-control" value="{{ old('working',$user->details->working) }}">
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label">Alamat Kantor</label>
                <input type="text" name="address_office" class="form-control" value="{{ old('address_office',$user->details->address_office) }}">
              </div>
            </div>
            <div class="text-end">
              <a href="{{ route('petugas.users.index') }}" class="btn btn-outline-secondary me-2">Batal</a>
              <button type="submit" class="btn btn-primary">Perbarui</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
