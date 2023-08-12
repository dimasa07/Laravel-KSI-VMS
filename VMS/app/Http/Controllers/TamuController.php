<?php

namespace App\Http\Controllers;

use App\Models\PermintaanBertamu;
use App\Models\Tamu;
use App\Services\AkunService;
use App\Services\BukuTamuService;
use App\Services\PegawaiService;
use App\Services\PermintaanBertamuService;
use App\Services\TamuService;
use App\Utilities\WaktuConverter;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class TamuController extends Controller
{
    public function __construct(
        public TamuService $tamuService,
        public AkunService $akunService,
        public PermintaanBertamuService $permintaanBertamuService,
        public BukuTamuService $bukuTamuService,
        public PegawaiService $pegawaiService
    ) {
    }

    public function index()
    {
        return view('tamu.index');
    }

    public function viewBuatPermintaan()
    {
        $rs = $this->pegawaiService->getAll();
        $pegawai = $rs->hasil->data;
        return view('tamu.tambah_permintaan', compact('pegawai'));
    }

    public function riwayatPermintaan(Request $request)
    {
        $id_tamu = $request->session()->get('id'); //$this->akunService->getByUsername($request->session()->get('username'))->hasil->data->tamu->id;
        $permintaan = $this->permintaanBertamuService->getByIdTamu($id_tamu)->hasil->data;
        $rs = $this->pegawaiService->getAll();
        $pegawai = $rs->hasil->data;
        foreach ($permintaan as $p) {
            if ($p->status == 'DISETUJUI') {
                $cekWaktuBertamu = Carbon::createFromFormat('Y-m-d H:i:s', $p->waktu_bertamu);
                $batas_waktu = $p->batas_waktu;
                $cekWaktuBertamu->addMinutes($batas_waktu);
                $p['maks'] = WaktuConverter::convertToDateTime($cekWaktuBertamu->toDateTimeString());
            }
            $p->waktu_pengiriman = WaktuConverter::convertToDateTime($p->waktu_pengiriman);
            $p->waktu_bertamu = WaktuConverter::convertToDateTime($p->waktu_bertamu);
            $p->waktu_pemeriksaan = WaktuConverter::convertToDateTime($p->waktu_pemeriksaan);
        }
        return view('tamu.riwayat_permintaan', [
            'permintaan' => $permintaan,
            'pegawai' => $pegawai
        ]);
    }

    public function riwayatBertamu(Request $request)
    {
        $id_tamu = $request->session()->get('id'); //$this->akunService->getByUsername($request->session()->get('username'))->hasil->data->tamu->id;
        $bukuTamu = $this->bukuTamuService->getByIdTamu($id_tamu)->hasil->data;
        foreach ($bukuTamu as $bk) {
            $bk->check_in = WaktuConverter::convertToDateTime($bk->check_in);
            $bk->check_out = WaktuConverter::convertToDateTime($bk->check_out);
        }
        return view('tamu.riwayat_bertamu', compact('bukuTamu'));
        // return response()->json($bukuTamu);
    }

    public function tambahPermintaan(Request $request)
    {
        // $waktuPengiriman = Carbon::now()->toDateTimeString();
        // $permintaan->waktu_pengiriman = $waktuPengiriman;
        // $rs = $this->permintaanBertamuService->save($permintaan);
        $id_tamu = $this->akunService->getByUsername($request->session()->get('username'))->hasil->data->tamu->id;
        $waktu_bertamu = $request->input('tanggal') . ' ' . $request->input('waktu') . ':00';
        $id_pegawai = $request->input('id_pegawai');
        $keperluan = $request->input('keperluan');
        $waktu_pengiriman = Carbon::now()->toDateTimeString();
        $data = [
            'id_tamu' => $id_tamu,
            'id_pegawai' => $id_pegawai,
            'keperluan' => $keperluan,
            'waktu_bertamu' => $waktu_bertamu,
            'waktu_pengiriman' => $waktu_pengiriman
        ];
        $permintaan = new PermintaanBertamu();
        $permintaan->fill($data);
        $rs = $this->permintaanBertamuService->save($permintaan);
        $tipe = $rs->sukses ? 'sukses' : 'gagal';
        return back()->with($tipe, $rs->pesan[0]);
        // return response()->json($data);
    }

    public function profil(Request $request)
    {
        $tamu = new Tamu();
        $rs = $this->tamuService->getById($request->session()->get('id'));
        if ($rs->sukses) {
            $tamu = $rs->hasil->data;
        }
        return view('tamu.profil', compact('tamu'));
        // return response()->json($admin);
    }

    public function akun(Request $request)
    {
        $rs = $this->akunService->getByUsername($request->session()->get('username'));
        $akun = $rs->hasil->data;
        return view('tamu.akun', compact('akun'));
        // return response()->json($admin);
    }

    public function updateProfil(Request $request)
    {
        if ($request->session()->get('id') == 0) {
            $tamu = new Tamu();
            $tamu->fill($request->input());
            $checkNIK = $this->tamuService->getByNIK($tamu->nik);
            $id_akun = $this->akunService->getByUsername($request->session()->get('username'))->hasil->data->id;
            if ($checkNIK->sukses && $checkNIK->hasil->data->id_akun == null) {
                $rs = $this->tamuService->update($checkNIK->hasil->data->id, ['id_akun' => $id_akun, 'nik' => $tamu->nik]);
            } else {
                $tamu->id_akun = $id_akun;
                $rs = $this->tamuService->save($tamu);
            }
            if ($rs->sukses) {
                $request->session()->put('id', $rs->hasil->data->id);
            }
        } else {
            $rs = $this->tamuService->update($request->input('id'), $request->input());
        }
        if ($rs->sukses) {
            $request->session()->put('nama', $rs->hasil->data->nama);
            $rs->pesan[0] = 'Sukses update Profil';
        }
        $tipe = $rs->sukses ? 'sukses' : 'gagal';
        Session::flash($tipe, $rs->pesan[0]);
        return response()->json($rs);
    }

    public function updateAkun(Request $request)
    {
        $rs = $this->akunService->update($request->input('id'), $request->input());
        if ($rs->sukses) {
            $request->session()->put('username', $request->input('username'));
        }
        $tipe = $rs->sukses ? 'sukses' : 'gagal';
        Session::flash($tipe, $rs->pesan[0]);
        return response()->json($rs);
    }

    public function allPermintaanBertamu($idTamu)
    {
        $rs = $this->permintaanBertamuService->getByIdTamu($idTamu);
        return response()->json($rs);
    }

    public function updatePermintaanBertamu(Request $request)
    {
        $waktu_bertamu = $request->input('tanggal') . ' ' . $request->input('waktu') . ':00';
        $id_pegawai = $request->input('id_pegawai');
        $keperluan = $request->input('keperluan');
        $waktu_pengiriman = Carbon::now()->toDateTimeString();
        if(is_null($id_pegawai)){
            $id_pegawai = $this->permintaanBertamuService->getById($request->input('id'))->hasil->data->id_pegawai;
        }
        $data = [
            'id_pegawai' => $id_pegawai,
            'keperluan' => $keperluan,
            'waktu_bertamu' => $waktu_bertamu,
            'waktu_pengiriman' => $waktu_pengiriman
        ];
        $rs = $this->permintaanBertamuService->update($request->input('id'), $data);
        $tipe = $rs->sukses ? 'sukses' : 'gagal';
        return back()->with($tipe, $rs->pesan[0]);
        // return response()->json($request->input());
    }

    public function deletePermintaanBertamu($id)
    {
        $rs = $this->permintaanBertamuService->delete($id);
        $tipe = $rs->sukses ? 'sukses' : 'gagal';
        return back()->with($tipe, $rs->pesan[0]);
    }

    public function deleteAkun(Request $request)
    {
        $rs = $this->akunService->deleteByUsername($request->session()->get('username'));
        return redirect()->route('user.logout');
        // return response()->json($rs);
    }
}
