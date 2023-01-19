@extends('layouts.dashboard.app')

@section('container-dashboard')
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-1 mb-2">
    <h2>Data Perusahaan</h2>
    <a href="{{ route('admin.perusahaan.create') }}" class="btn btn-primary">
      Tambah Data Perusahaan
    </a>
  </div>

  <x-alert-session />

  <div class="row">
    <div class="col table-responsive">
      <div class="table-responsive pb-2">
        <table @if ($perusahaan->count() > 0) id="myTable" @endif
          class="table table-bordered border-secondary table-striped py-2">
          <thead class="table-dark">
            <tr>
              <th scope="col" class="text-nowrap text-center vertical-align-middle custom-font">No</th>
              <th scope="col" class="text-nowrap text-center vertical-align-middle custom-font">Nama Perusahaan</th>
              <th scope="col" class="text-nowrap text-center vertical-align-middle custom-font">Username Perusahaan
              </th>
              <th scope="col" class="text-nowrap text-center vertical-align-middle custom-font">Email Perusahaan</th>
              <th scope="col" class="text-nowrap text-center vertical-align-middle custom-font">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($perusahaan as $item)
              <tr>
                <th class="text-nowrap text-center vertical-align-middle custom-font" scope="row">
                  {{ $loop->iteration }}
                </th>
                <td class="text-nowrap text-center vertical-align-middle custom-font">
                  {{ $item->nama_perusahaan }}
                </td>
                <td class="text-nowrap text-center vertical-align-middle custom-font">
                  {{ $item->user->username }}
                </td>
                <td class="text-nowrap text-center vertical-align-middle custom-font">
                  {{ $item->user->email }}
                </td>
                <td class="text-nowrap text-center vertical-align-middle custom-font">
                  <div class="d-flex gap-2 align-items-center justify-content-center">
                    <a href="{{ route('admin.perusahaan.detail', $item->user->username) }}"
                      class="btn custom-btn btn-success">
                      <span><i class="fa-solid fa-circle-info fa-lg"></i></span>
                    </a>
                    <a href="{{ route('admin.perusahaan.edit', $item->user->username) }}"
                      class="btn custom-btn btn-warning">
                      <span><i class="fa-solid fa-pen-to-square fa-lg"></i></span>
                    </a>
                    <button type="button" class="btn custom-btn btn-danger btn-delete" data-bs-toggle="modal"
                      data-bs-target="#modalHapus" data-username="{{ $item->user->username }}">
                      <span><i class="fa-solid fa-trash fa-lg"></i></span>
                    </button>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="5" class="fs-5 text-center">
                  <x-svg-empty-icon />
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

  {{-- Modal Hapus --}}
  <div class="modal fade" id="modalHapus" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header border-0 border-bottom-0">
          <h1 class="modal-title fs-4 text-center" id="exampleModalLabel">Hapus data pelamar?</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-footer border-0 border-top-0">
          <form class="form-modal" method="post">
            @csrf
            @method('delete')
            <button type="button" class="btn btn-secondary btn-cancel" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-danger">Hapus</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  @push('script')
    <script>
      const btnDelete = document.querySelectorAll('.btn-delete');
      btnDelete.forEach(btn => {
        btn.addEventListener('click', () => {
          console.dir(btn);
          const formModal = document.querySelector('.modal .form-modal');
          const btnCancel = document.querySelector('.modal .btn-cancel');
          const btnClose = document.querySelector('.modal .btn-close');
          const username = btn.dataset.username;
          const route = "{{ route('admin.perusahaan.delete', ':username') }}";
          formModal.setAttribute('action', route.replace(':username', username));
          btnCancel.addEventListener('click', () => formModal.removeAttribute('action'));
          btnClose.addEventListener('click', () => formModal.removeAttribute('action'));
        });
      });
    </script>
  @endpush
@endsection
