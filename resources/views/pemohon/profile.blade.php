@extends('layouts.admin')

@section('title','Profile Pemohon')
@section('header','Profile Pemohon')

@section('admin-content')
<div class="container mt-4">
    <h2>Profil Saya</h2>
    @if(session('info'))
      <div class="alert alert-info">{{ session('info') }}</div>
    @endif
    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('pemohon.updateProfile') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">No. Identitas</label>
            <input type="text"
                   name="number_identification"
                   value="{{ old('number_identification', $details->number_identification ?? '') }}"
                   class="form-control @error('number_identification') is-invalid @enderror"
                   required>
            @error('number_identification')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">No. Telepon</label>
            <input type="text"
                   name="number_phone"
                   value="{{ old('number_phone', $details->number_phone ?? '') }}"
                   class="form-control @error('number_phone') is-invalid @enderror"
                   required>
            @error('number_phone')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Alamat</label>
            <textarea name="address"
                      class="form-control @error('address') is-invalid @enderror"
                      rows="3"
                      required>{{ old('address', $details->address ?? '') }}</textarea>
            @error('address')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Pekerjaan</label>
            <input type="text"
                   name="working"
                   value="{{ old('working', $details->working ?? '') }}"
                   class="form-control">
            @error('working')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Alamat Kantor</label>
            <input type="text"
                   name="address_office"
                   value="{{ old('address_office', $details->address_office ?? '') }}"
                   class="form-control">
            @error('address_office')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Simpan Profil</button>
    </form>
</div>
@endsection
