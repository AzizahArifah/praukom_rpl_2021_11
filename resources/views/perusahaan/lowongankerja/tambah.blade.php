@extends('layouts.dashboard.app')

@section('container-dashboard')
  <div class="row pt-3 pb-1 mb-1">
    <div class="col">
      <div class="card">
        <div class="card-header pb-0">
          <h2>Tambah Lowongan Kerja</h2>
        </div>
        <div class="card-body">
          @if (!empty($errors->all()))
            <div class="row">
              <div class="col">
                <div class="alert pb-0 alert-danger alert-dismissible fade show fs-6" role="alert">
                  <ul>
                    @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                    @endforeach
                  </ul>
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
              </div>
            </div>
          @endif
          <form action="/" method="POST">
            @csrf
            <div class="mb-3 row">
              <label for="judul" class="col-sm-4 col-form-label text-md-end fs-6 fs-md-5">
                {{ __('Judul Lowongan') }}
              </label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="judul" name="judul" placeholder="IT Consultant"
                  required>
              </div>
            </div>
            <div class="mb-3 row">
              <label for="deskripsi" class="col-sm-4 col-form-label text-md-end fs-6 fs-md-5">
                {{ __('Deskripsi') }}
              </label>
              <div class="col-sm-8">
                <textarea class="form-control" placeholder="Leave a comment here" id="deskripsi" name="deskripsi" rows="5"></textarea>
              </div>
            </div>
            <div class="mb-3 row">
              <label for="tanggal_dimulai" class="col-sm-4 col-form-label text-md-end fs-6 fs-md-5">
                {{ __('Tanggal Dimulai') }}
              </label>
              <div class="col-sm-8">
                <input type="date" class="form-control" id="tanggal_dimulai" name="tanggal_dimulai"
                  placeholder="28/12/2022">
              </div>
            </div>
            <div class="mb-3 row">
              <label for="tanggal_berakhir" class="col-sm-4 col-form-label text-md-end fs-6 fs-md-5">
                {{ __('Tanggal Berakhir') }}
              </label>
              <div class="col-sm-8">
                <input type="date" class="form-control" id="tanggal_berakhir" name="tanggal_berakhir"
                  placeholder="28/12/2022">
              </div>
            </div>
            <div class="mb-3 row">
              <label for="gambar_lowongan" class="col-sm-4 col-form-label text-md-end fs-6 fs-md-5">
                {{ __('Gambar Lowongan') }}
              </label>
              <div class="col-sm-8">
                <input type="file" class="form-control" id="gambar_lowongan" name="gambar_lowongan">
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-sm-4"></div>
              <div class="col-sm-8 d-flex gap-2">
                <button type="submit" class="btn btn-primary">Tambah</button>
                <a href="/" class="btn btn-danger">Batal</a>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
