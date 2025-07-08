@extends('layouts.admin')

@section('admin-content')
<div class="container-fluid py-4">
  <div class="row justify-content-center">
    <div class="col-lg-6">
      <div class="card shadow-sm border-0">
        <div class="card-header bg-light">
          <h5 class="mb-0">Informasi Profil</h5>
        </div>
        <div class="card-body">
          @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
          @endif
          @if($errors->any())
            <div class="alert alert-danger">
              <ul class="mb-0">
                @foreach($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif
          <form action="{{ route('bidang.profile.update') }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
              <label class="form-label">Nama Lengkap</label>
              <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Email</label>
              <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
            </div>
            <div class="mb-3">
              <label class="form-label">No. Identitas</label>
              <input type="text" name="number_identification" class="form-control" value="{{ old('number_identification', $details->number_identification ?? '') }}" required>
            </div>
            <div class="mb-3">
              <label class="form-label">No. Telepon</label>
              <input type="text" name="number_phone" class="form-control" value="{{ old('number_phone', $details->number_phone ?? '') }}" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Alamat</label>
              <textarea name="address" class="form-control" rows="2" required>{{ old('address', $details->address ?? '') }}</textarea>
            </div>
            <div class="mb-3">
              <label class="form-label">Pekerjaan</label>
              <input type="text" name="working" class="form-control" value="{{ old('working', $details->working ?? '') }}">
            </div>
            <div class="mb-3">
              <label class="form-label">Alamat Kantor</label>
              <input type="text" name="address_office" class="form-control" value="{{ old('address_office', $details->address_office ?? '') }}">
            </div>
            <div class="text-end">
              <button type="submit" class="btn btn-primary">Perbarui Profil</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
