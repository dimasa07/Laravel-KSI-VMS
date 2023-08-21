<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use App\Models\Akun;
use App\Models\Pegawai;
use App\Services\AkunService;
use App\Services\BukuTamuService;
use App\Services\PegawaiService;
use App\Services\PermintaanBertamuService;
use App\Services\ResultSet;
use App\Services\TamuService;
use App\Utilities\WaktuConverter;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use Barryvdh\DomPDF\Facade\Pdf;
use Dompdf\Options;
use Dompdf\Dompdf;

use Hash;


class AdminController extends Controller
{

    public function __construct(
        public AkunService $akunService,
        public PegawaiService $pegawaiService,
        public BukuTamuService $bukuTamuService,
        public PermintaanBertamuService $permintaanBertamuService,
        public TamuService $tamuService
    ) {
    }

    public function index()
    {
     $totalPermintaan = 0;
    $permintaanBelumDiperiksa = 0;
        $permintaanDisetujui = 0;
        $permintaanDitolak = 0;
        $laporanHariIni = 0;
        $totalLaporan = 0;
        $saatIni = Carbon::now();

        $dataPermintaan = $this->permintaanBertamuService->getAll()->hasil->data;
        $dataPermintaanHariIni = [];
        $dataLaporanHariIni = [];
        foreach ($dataPermintaan as $permintaan) {
            if ($permintaan->status != 'KADALUARSA') {
                $totalPermintaan++;
            }
            $cekWaktu = Carbon::createFromFormat('Y-m-d H:i:s', $permintaan->waktu_pengiriman);
            if ($cekWaktu->day == $saatIni->day && $cekWaktu->month == $saatIni->month && $cekWaktu->year == $saatIni->year) {
                $permintaan->waktu_pengiriman = WaktuConverter::convertToDateTime($permintaan->waktu_pengiriman);
                $dataPermintaanHariIni[] = $permintaan;
            }
            switch ($permintaan->status) {
                case 'BELUM DIPERIKSA':
                $permintaanBelumDiperiksa++; 
                break;
                case 'DISETUJUI':
                $permintaanDisetujui++;
                break;
                case 'DITOLAK':
                $permintaanDitolak++;
                break;
            }
        }


        $dataBukuTamu = $this->bukuTamuService->getAll()->hasil->data;
        foreach ($dataBukuTamu as $bukuTamu) {
            $cekWaktu = Carbon::createFromFormat('Y-m-d H:i:s', $bukuTamu->check_in);
            if ($cekWaktu->day == $saatIni->day && $cekWaktu->month == $saatIni->month && $cekWaktu->year == $saatIni->year) {
                $laporanHariIni++;
                $bukuTamu->check_in = WaktuConverter::convertToDateTime($bukuTamu->check_in);
                $dataLaporanHariIni[] = $bukuTamu;
            }
        }

        $totalLaporan = count($dataBukuTamu);

        return view('admin.index', [
            'totalPermintaan' => $totalPermintaan,
            'permintaanBelumDiperiksa' => $permintaanBelumDiperiksa,
            'permintaanDisetujui' => $permintaanDisetujui,
            'permintaanDitolak' => $permintaanDitolak,
            'laporanHariIni' => $laporanHariIni,
            'totalLaporan' => $totalLaporan,
            'dataPermintaanHariIni' => $dataPermintaanHariIni,
            'dataLaporanHariIni' => $dataLaporanHariIni
        ]);
    }

    public function tambahPegawai(Request $request)
    {
        $rs = new ResultSet();
        $rs->hasil->tipe = 'Object';
        $pegawai = new Pegawai();
        $pegawai->fill($request->input());
        $cekPegawai = $this->pegawaiService->getByNIP($pegawai->nip);
        if ($cekPegawai->sukses) {
            $rs->pesan[] = 'Gagal tambah, NIP sudah terdaftar';
        } else {
            $akun = null;
            if ($request->input('username') != '') {
                $akun = new Akun();
                $akun->fill($request->input());
                $saveAkun = $this->akunService->save($akun);
                if (!$saveAkun->sukses) {
                    $rs->pesan = $saveAkun->pesan;
                    return response()->json($rs);
                } else {
                    $pegawai->id_akun = $akun->id;
                }
            }
            $savePegawai = $this->pegawaiService->save($pegawai);
            $rs->sukses = $savePegawai->sukses;
            $rs->pesan[] = 'Sukses tambah Pegawai';
            $rs->hasil->jumlah = 1;
            $rs->hasil->data['pegawai'] = $pegawai;
            $rs->hasil->data['akun'] = $akun;
        }

        $tipe = $rs->sukses ? 'sukses' : 'gagal';
        Session::flash($tipe, $rs->pesan[0]);
        return response()->json($rs);
    }

    public function profil(Request $request)
    {
        // $rs = $this->pegawaiService->getByNIP($request->session()->get('nip'));
        $admin = Auth::user()->pegawai;
        return view('admin.profil', compact('admin'));
        // return response()->json($admin);
    }

    public function akun(Request $request)
    {
        $rs = $this->akunService->getByUsername($request->session()->get('username'));
        $akun = $rs->hasil->data;
        return view('admin.akun', compact('akun'));
        // return response()->json($admin);
    }

    public function allPegawai()
    {
        $rs = $this->pegawaiService->getAll();
        $pegawai = $rs->hasil->data;
        return view('admin.data_pegawai', compact('pegawai'));
        // return response()->json($admin);
    }

    public function allAdmin()
    {
        $rs = $this->pegawaiService->getAllAdmin();
        $admin = $rs->hasil->data;
        return view('admin.data_admin', compact('admin'));
        // return response()->json($rs);
    }

    public function allFrontOffice()
    {
        $rs = $this->pegawaiService->getAllFrontOffice();
        $frontOffice = $rs->hasil->data;
        return view('admin.data_front_office', compact('frontOffice'));
        // return response()->json($rs);
    }

    public function allTamu()
    {
        $rs = $this->tamuService->getAll();
        $tamu = $rs->hasil->data;
        return view('admin.data_tamu', compact('tamu'));
        //return response()->json($rs);
    }

    public function allPermintaanBertamu(Request $request)
    {
        $rs = $this->permintaanBertamuService->getAll();
        $semuaPermintaan = $rs->hasil->data;
        foreach ($rs->hasil->data as $permintaan) {
            if ($permintaan->status == 'DISETUJUI') {
                $cekWaktuBertamu = Carbon::createFromFormat('Y-m-d H:i:s', $permintaan->waktu_bertamu);
                $batas_waktu = $permintaan->batas_waktu;
                $cekWaktuBertamu->addMinutes($batas_waktu);
                $permintaan['maks'] = WaktuConverter::convertToDateTime($cekWaktuBertamu->toDateTimeString());
            }
            $permintaan->waktu_bertamu = WaktuConverter::convertToDateTime($permintaan->waktu_bertamu);
            $permintaan->waktu_pengiriman = WaktuConverter::convertToDateTime($permintaan->waktu_pengiriman);
            $permintaan->waktu_pemeriksaan = WaktuConverter::convertToDateTime($permintaan->waktu_pemeriksaan);
        }
        return view('admin.data_permintaan', [
            'semuaPermintaan' => $semuaPermintaan
        ]);

        // return response()->json($rs);
    }

    public function allBukuTamu()
    {
        $rs = $this->bukuTamuService->getAll();
        $bukuTamu = $rs->hasil->data;
        $currentTime = Carbon::now();
        foreach ($bukuTamu as $bk) {
            $cekWaktu = Carbon::createFromFormat('Y-m-d H:i:s', $bk->check_in);
            $bk['filter'] = 'SEMUA';
            if (($cekWaktu->month == $currentTime->month) && ($cekWaktu->year == $currentTime->year)) {
                $bk['filter'] = 'BULAN INI';
            }
            if (($cekWaktu->weekOfMonth == $currentTime->weekOfMonth) && ($cekWaktu->month == $currentTime->month) && ($cekWaktu->year == $currentTime->year)) {
                $bk['filter'] = 'MINGGU INI';
            }
            if (($cekWaktu->day == $currentTime->day) && ($cekWaktu->month == $currentTime->month) && ($cekWaktu->year == $currentTime->year)) {
                $bk['filter'] = 'HARI INI';
            }
            $bk->check_in = WaktuConverter::convertToDateTime($bk->check_in);
            $bk->check_out = WaktuConverter::convertToDateTime($bk->check_out);
        }
        $data = [
            'semua' => $bukuTamu
        ];
        // return response()->json($data);
        return view('admin.data_buku_tamu', $data);
    }

    public function cetakBukuTamu($filter)
    {
        $rs = $this->bukuTamuService->getAll();
        $bukuTamu = $rs->hasil->data;
        $currentTime = Carbon::now();
        $hariIni = [];
        $mingguIni = [];
        $bulanIni = [];
        foreach ($bukuTamu as $bk) {
            $cekWaktu = Carbon::createFromFormat('Y-m-d H:i:s', $bk->check_in);
            $bk->check_in = WaktuConverter::convertToDateTime($bk->check_in);
            $bk->check_out = WaktuConverter::convertToDateTime($bk->check_out);
            $bk['filter'] = 'SEMUA';
            if (($cekWaktu->month == $currentTime->month) && ($cekWaktu->year == $currentTime->year)) {
                $bulanIni[] = $bk;
                $bk['filter'] = 'BULAN INI';
            }
            if (($cekWaktu->weekOfMonth == $currentTime->weekOfMonth) && ($cekWaktu->month == $currentTime->month) && ($cekWaktu->year == $currentTime->year)) {
                $mingguIni[] = $bk;
                $bk['filter'] = 'MINGGU INI';
            }
            if (($cekWaktu->day == $currentTime->day) && ($cekWaktu->month == $currentTime->month) && ($cekWaktu->year == $currentTime->year)) {
                $hariIni[] = $bk;
                $bk['filter'] = 'HARI INI';
            }
        }
        $wc = new WaktuConverter($currentTime->toDateTimeString());
        $waktu = '';
        $tipe = '';
        switch ($filter) {
            case 'SEMUA':
            $tipe = 'Keseluruhan';
            break;
            case 'HARI INI':
            $tipe = 'Harian';
            $waktu = $wc->getDate();
            $bukuTamu = $hariIni;
            break;
            case 'MINGGU INI':
            $tipe = 'Mingguan';
            $tmp = Carbon::now();
            $tmp->addDays(- ($currentTime->dayOfWeek));
            $wc1 = new WaktuConverter($tmp->toDateTimeString());
            $low = $wc1->getDate();
            $tmp->addDays(6);
            $wc1 = new WaktuConverter($tmp->toDateTimeString());
            $high = $wc1->getDate();
            $waktu = $low . ' - ' . $high;
            $bukuTamu = $mingguIni;
            break;
            case 'BULAN INI':
            $tipe = 'Bulanan';
            $waktu = $wc->bulan . ' ' . $wc->tahun;
            $bukuTamu = $bulanIni;
            break;
        }
        $data = [
            'tipe' => $tipe,
            'waktu' => $waktu,
            'semua' => $bukuTamu,
        ];
        // return response()->json($data);
        $pdf = Pdf::setOptions(['isRemoteEnabled' => true])->loadView('layouts.laporan', $data);

        $namaFile = $tipe == 'Keseluruhan' ? 'Laporan Tamu ' . $tipe . '.pdf' : 'Laporan Tamu ' . $tipe . '_' . $waktu . '.pdf';
        return $pdf->download($namaFile);
    }

    public function getTamuByNIK(string $nik)
    {
        $rs = $this->tamuService->getByNIK($nik);
        return response()->json($rs);
    }

    public function setujuiPermintaan(Request $request, string $idPermintaan)
    {
        $admin = $this->akunService->getByUsername($request->session()->get('username'))->hasil->data;
        $waktuPemeriksaan = Carbon::now()->toDateTimeString();
        $batas_waktu = is_numeric($request->input('batas_waktu')) ? $request->input('batas_waktu') : 30;
        $rs = $this->permintaanBertamuService->update($idPermintaan, [
            'status' => 'DISETUJUI',
            'waktu_pemeriksaan' => $waktuPemeriksaan,
            'id_admin' => $admin->id,
            'batas_waktu' => $batas_waktu
        ]);
        if ($rs->sukses) {
            $tipe = "sukses";
            $pesan = "Sukses menyetujui Permintaan.";
        } else {
            $tipe = "gagal";
            $pesan = "Gagal menyetujui Permintaan.";
        }
        return back()->with($tipe, $pesan);

        // return response()->json($rs);
    }

    public function tolakPermintaan(Request $request)
    {
        $admin = $this->akunService->getByUsername($request->session()->get('username'))->hasil->data;
        $waktuPemeriksaan = Carbon::now()->toDateTimeString();
        $rs = $this->permintaanBertamuService->update($request->input('id'), [
            'status' => 'DITOLAK',
            'waktu_pemeriksaan' => $waktuPemeriksaan,
            'id_admin' => $admin->id,
            'pesan_ditolak' => $request->input('pesan_ditolak')
        ]);
        if ($rs->sukses) {
            $tipe = "sukses";
            $pesan = "Sukses menolak Permintaan.";
        } else {
            $tipe = "gagal";
            $pesan = "Gagal menolak Permintaan.";
        }
        Session::flash($tipe, $pesan);
        return response()->json($rs);
    }

    public function updateProfil(Request $request)
    {
        $rs = $this->pegawaiService->update($request->input('id'), $request->input());
        if ($rs->sukses) {
            $request->session()->put('nama', $rs->hasil->data->nama);
        }
        $tipe = $rs->sukses ? 'sukses' : 'gagal';
        Session::flash($tipe, $rs->pesan[0]);
        return response()->json($rs);
    }

    public function updateAkun(Request $request)
    {
        $arr = $request->input();
        if($request->password)
            $arr['password']  = Hash::make($request->passwword);
        $rs = $this->akunService->update($request->input('id'), $arr);
        if ($rs->sukses) {
            $request->session()->put('username', $rs->hasil->data->username);
        }
        $tipe = $rs->sukses ? 'sukses' : 'gagal';
        Session::flash($tipe, $rs->pesan[0]);
        // return response()->json($rs);
        return response()->json([
                'XSRF-TOKEN' => $request->header('XSRF-TOKEN'),
                '_token' => $request->input('_token'),
                'request token' => $request->session()->token(),
        ]);
    }

    public function updatePegawai(Request $request)
    {
        $rs = $this->pegawaiService->update($request->input('id'), $request->input());
        if ($rs->sukses) {
            $rs->pesan[0] = 'Sukses update Pegawai';
        }
        $tipe = $rs->sukses ? 'sukses' : 'gagal';
        Session::flash($tipe, $rs->pesan[0]);
        return response()->json($rs);
    }



    public function updateBukuTamu(Request $request)
    {
        $rs = $this->bukuTamuService->update($request->input('id'), $request->input());
        return response()->json($rs);
    }

    public function deleteTamu($id)
    {
        $rs = $this->tamuService->delete($id);
        if ($rs->sukses) {
            $tipe = "sukses";
            $pesan = "Sukses hapus data Tamu.";
        } else {
            $tipe = "gagal";
            $pesan = "Gagal hapus data Tamu.";
        }
        return back()->with($tipe, $pesan);
    }

    public function deleteBukuTamu($id)
    {
        $rs = $this->bukuTamuService->delete($id);
        if ($rs->sukses) {
            $tipe = "sukses";
            $pesan = "Sukses hapus data Laporan.";
        } else {
            $tipe = "gagal";
            $pesan = "Gagal hapus data Laporan.";
        }
        return back()->with($tipe, $pesan);
    }

    public function deletePegawai($id)
    {
        $rs = $this->pegawaiService->delete($id);
        if ($rs->sukses) {
            $tipe = "sukses";
            $pesan = "Sukses hapus data Pegawai.";
        } else {
            $tipe = "gagal";
            $pesan = "Gagal hapus data Pegawai.";
        }
        return back()->with($tipe, $pesan);
    }
}
