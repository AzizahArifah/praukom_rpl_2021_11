<?php

namespace App\Http\Controllers\AdminDanPerusahaan;

use App\Http\Controllers\Controller;
use App\Models\Kantor;
use App\Models\MitraPerusahaan;
use App\Traits\HasCity;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;

final class KantorController extends Controller {
  use HasCity;

  private $kantorByMitraColumn = [
    'alamat_kantor',
    'wilayah_kantor',
    'status_kantor',
    'no_telp_kantor',
  ];

  private $kantorByAdminColumn = [
    'id_perusahaan',
    'alamat_kantor',
    'wilayah_kantor',
    'status_kantor',
    'no_telp_kantor',
  ];

  private $defaultRules = [
    'alamat_kantor' => ['required'],
    'wilayah_kantor' => ['required'],
    'status_kantor' => ['required'],
    'no_telp_kantor' => ['required'],
  ];

  private function getMitraData(): Collection {
    return MitraPerusahaan::all(['id_perusahaan', 'jenis_perusahaan', 'nama_perusahaan']);
  }

  public function getAllKantorData(string $username = null): View {
    $dataMitra = null;
    $kantor = null;

    if (Gate::check('admin')) {
      $kantor = Kantor::with('perusahaan')->latest()->paginate(10)->withQueryString();
    } else if (Gate::check('perusahaan')) {
      $dataMitra = Auth::user()->perusahaan;
      $kantor = $dataMitra->kantor()->latest()->paginate(10)->withQueryString();
    }

    return view('kantor.index', compact('kantor', 'dataMitra'));
  }

  public function getDetailOneKantorData(Kantor $kantor): View {
    return view('kantor.detail', compact('kantor'));
  }

  public function createOneKantorData(): View {
    $mitra = $this->getMitraData();

    return view('kantor.tambah', [
      'kota' => $this->city,
      'mitra' => $mitra
    ]);
  }

  public function storeOneKantorData(Request $request): Redirector|RedirectResponse {
    if (Gate::check('admin')) {
      $this->defaultRules['id_perusahaan'] = ['required'];
      $request->validate($this->defaultRules);
      $validatedData = $request->only($this->kantorByAdminColumn);

      if ($request->boolean('kantor_utama')) {
        Kantor::where('id_perusahaan', $validatedData['id_perusahaan'])
          ->where('kantor_utama', true)
          ->update(['kantor_utama' => false]);
      }

      Kantor::create([
        ...$validatedData,
        'kantor_utama' => $request->boolean('kantor_utama')
      ]);
    } else if (Gate::check('perusahaan')) {
      $request->validate($this->defaultRules);
      $validatedData = $request->only($this->kantorByMitraColumn);

      if ($request->boolean('kantor_utama')) {
        Auth::user()->perusahaan->kantor()
          ->where('kantor_utama', true)
          ->update(['kantor_utama' => false]);
      }

      Auth::user()->perusahaan->kantor()->create([
        ...$validatedData,
        'kantor_utama' => $request->boolean('kantor_utama')
      ]);
    }

    notify()->success('Berhasil menambahkan data kantor baru', 'Notifikasi');

    return to_route('kantor.index');
  }

  public function editOneKantorData(Kantor $kantor): View {
    return view('kantor.sunting', [
      'kantor' => $kantor,
      'kota' => $this->city,
    ]);
  }

  public function updateOneKantorData(Request $request, Kantor $kantor): Redirector|RedirectResponse {
    $request->validate($this->defaultRules);
    $validatedData = $request->only($this->kantorByAdminColumn);

    if ($request->boolean('kantor_utama')) {
      Kantor::where('id_perusahaan', $kantor->perusahaan->id_perusahaan)
        ->where('kantor_utama', true)
        ->update(['kantor_utama' => false]);
      $validatedData['kantor_utama'] = $request->boolean('kantor_utama');
    }

    $kantor->update($validatedData);

    notify()->success('Berhasil memperbarui data kantor', 'Notifikasi');

    return to_route('kantor.index');
  }

  public function deleteOneKantorData(Kantor $kantor): Redirector|RedirectResponse {
    $kantor->delete();
    notify()->success('Berhasil menghapus data kantor', 'Notifikasi');
    return back();
  }
}
