@extends('layouts.dashboard.app')

@section('container-dashboard')
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-1 mb-2">
    <h2>Data Alumni</h2>
    <a href="{{ route('admin.alumni.create') }}" class="btn btn-primary custom-btn">Tambah Data Alumni</a>
  </div>

  <div class="row my-2 gap-3 gap-md-0">
    <x-card-admin bgcolor="text-bg-warning">
      @slot('data')
        <div class="d-flex justify-content-between align-items-center">
          <span class="fs-3 fw-medium">Rekomendasi</span>
          <span><i class="fa-solid fa-star" style="font-size: 3rem"></i></span>
        </div>
      @endslot
      <a class="text-decoration-none stretched-link text-dark">
        <h4>Selengkapnya</h4>
      </a>
    </x-card-admin>
    <x-card-admin bgcolor="text-bg-indigo">
      @slot('data')
        <div class="d-flex justify-content-between align-items-center">
          <span class="fs-3 fw-medium">Penelusuran Alumni</span>
          <span><i class="fa-solid fa-user-graduate" style="font-size: 3rem"></i></span>
        </div>
      @endslot
      <a class="text-decoration-none stretched-link text-white d-flex gap-2 align-items-center">
        <h4>Selengkapnya</h4>
      </a>
    </x-card-admin>
  </div>

  <div class="row">
    <div class="col">
      <form action="{{ route('admin.alumni.index') }}">
        @csrf
        <div class="input-group mb-3">
          <input type="text" class="custom-font form-control" placeholder="Cari berdasarkan nama, nis atau jurusan"
            name="q" autocomplete="off" id="q" value="{{ request('q') }}">
          <button class="custom-font btn btn-success d-flex align-items-center gap-2" type="submit" id="button-addon2">
            <span><i class="fa-solid fa-magnifying-glass fa-lg"></i></span>
            <span>Cari</span>
          </button>
        </div>
      </form>
    </div>
  </div>

  <div class="row">
    <div class="col table-responsive">
      <div class="table-responsive pb-2">
        <table class="table table-bordered border-secondary table-striped py-2">
          <thead class="table-dark">
            <tr>
              <th scope="col" class="text-nowrap text-center vertical-align-middle custom-font">
                No
              </th>
              <th scope="col" class="text-nowrap text-center vertical-align-middle custom-font">
                Nama Alumni
              </th>
              <th scope="col" class="text-nowrap text-center vertical-align-middle custom-font">
                NIS / Username Alumni
              </th>
              <th scope="col" class="text-nowrap text-center vertical-align-middle custom-font">
                Jurusan
              </th>
              <th scope="col" class="text-nowrap text-center vertical-align-middle custom-font">
                Tahun Angkatan
              </th>
              <th scope="col" class="text-nowrap text-center vertical-align-middle custom-font">
                Aksi
              </th>
            </tr>
          </thead>
          <tbody>
            @forelse ($alumni as $key => $item)
              <tr>
                <th class="text-nowrap text-center vertical-align-middle custom-font" scope="row">
                  {{ $alumni->firstItem() + $key }}</th>
                <td class="text-nowrap text-center vertical-align-middle custom-font">
                  {{ $item->nama_lengkap }}
                </td>
                <td class="text-nowrap text-center vertical-align-middle custom-font">
                  {{ $item->pelamar->user->username }}
                </td>
                <td class="text-nowrap text-center vertical-align-middle custom-font">
                  {{ $item->jurusan->nama_jurusan }}
                </td>
                <td class="text-nowrap text-center vertical-align-middle custom-font">
                  {{ $item->angkatan->angkatan_tahun }}
                </td>
                <td class="text-nowrap text-center vertical-align-middle custom-font">
                  <div class="d-flex gap-2 align-items-center justify-content-center">
                    <a href="{{ route('admin.alumni.detail', $item->pelamar->user->username) }}"
                      class="btn custom-btn btn-success">
                      <span><i class="fa-solid fa-circle-info fa-lg"></i></span>
                    </a>
                    <a href="{{ route('admin.alumni.edit', $item->pelamar->user->username) }}"
                      class="btn custom-btn btn-warning">
                      <span><i class="fa-solid fa-pen-to-square fa-lg"></i></span>
                    </a>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="6" class="fs-5 text-center">
                  <x-svg-empty-icon />
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
        <div>{{ $alumni->links() }}</div>
      </div>
    </div>
  </div>
@endsection
