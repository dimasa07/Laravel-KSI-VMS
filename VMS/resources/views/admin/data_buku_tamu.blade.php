@extends('layouts.layout_admin')

@section('title','Admin - Laporan')

@section('content')
<!--Container-->
<div class="container w-full mx-auto pt-20">
    <div class="w-full px-4 md:px-0 md:mt-8 mb-16 text-gray-800 leading-normal">
        <div class="w-full p-3">
            <div class="bg-white border rounded shadow">
                <div class="border-b px-3 py-6">
                    <h5 class="ml-5 text-3xl font-bold uppercase text-gray-600">Laporan</h5>
                </div>
            </div>
        </div>

        <div class="w-full p-3">
            <div class="bg-white border rounded shadow" x-data="{ filter:'SEMUA',showAlert:true }">
                <div class="inline-flex border-b p-3 w-full">
                    <select x-model="filter" class="mx-4 py-1 px-4 bg-white border border-gray-600 rounded">
                        <option value="SEMUA">Semua</option>
                        <option value="HARI INI">Hari Ini</option>
                        <option value="MINGGU INI">Minggu Ini</option>
                        <option value="BULAN INI">Bulan Ini</option>
                    </select>
                    <a x-bind:href="window.location.origin+'/admin/buku-tamu/cetak/'+filter">
                        <button class="bg-orange-700 rounded py-1 px-4 text-white hover:bg-orange-900">Cetak</button>
                    </a>
                    @if($pesan = Session::get('gagal'))
                    <div x-show="showAlert" class="bg-red-500 text-white w-full text-center rounded mx-4 pt-1">
                        {{ $pesan }}
                    </div>
                    @endif
                    @if($pesan = Session::get('sukses'))
                    <div x-show="showAlert" class="bg-green-500 text-white w-full text-center rounded mx-4 pt-1">
                        {{ $pesan }}
                    </div>
                    @endif
                </div>
                <div class="p-5" x-data="{ bukuTamu:null,showDetail:false,showConfirmDelete:false }">
                    <div style="display: none;" x-show="showDetail" class="relative pb-11 px-6">
                        <table class="w-full p-5 text-gray-700">
                            <tbody>
                                <tr>
                                    <td class="w-40">Nama Tamu</td>
                                    <td class="w-6">:</td>
                                    <td x-text="bukuTamu.permintaan_bertamu.tamu.nama"></td>
                                </tr>
                                <tr>
                                    <td class="w-40">NIK</td>
                                    <td class="w-6">:</td>
                                    <td x-text="bukuTamu.permintaan_bertamu.tamu.nik"></td>

                                </tr>
                                <tr>
                                    <td class="w-40">Pegawai Dituju</td>
                                    <td class="w-6">:</td>
                                    <td x-text="bukuTamu.permintaan_bertamu.pegawai.nama"></td>

                                </tr>
                                <tr>
                                    <td class="w-40">Keperluan</td>
                                    <td class="w-6">:</td>
                                    <td x-text="bukuTamu.permintaan_bertamu.keperluan"></td>
                                </tr>
                                <tr>
                                    <td class="w-40">Check-In</td>
                                    <td class="w-6">:</td>
                                    <td x-text="bukuTamu.check_in"></td>
                                </tr>
                                <tr>
                                    <td class="w-40">Check-Out</td>
                                    <td class="w-6">:</td>
                                    <td x-text="bukuTamu.check_out"></td>
                                </tr>
                                <tr>
                                    <td class="w-40">Front Office penjaga</td>
                                    <td class="w-6">:</td>
                                    <td x-text="bukuTamu.front_office.nama"></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="inline-flex absolute right-0 bottom-0">
                            <!-- <button type="button" x-show="!showFormEdit" @click="showFormEdit= true; showDetail = false; showConfirmDelete=false;" class=" bg-blue-600 hover:bg-blue-800 text-white py-1 px-2 rounded mx-2">Edit Data</button>
                            <button style="display: none;" type="submit" @click="formData.id=pegawai.id; formData.nip=pegawai.nip" x-show="showFormEdit" class=" bg-green-600 hover:bg-green-800 text-white py-1 px-2 rounded mx-2">Simpan Perubahan</button> -->

                            <button x-show="!showConfirmDelete" @click="showConfirmDelete=!showConfirmDelete" class=" bg-red-600 hover:bg-red-800 text-white py-1 px-2 rounded mx-2">Hapus Data</button>
                            <a x-bind:href="window.location.origin+'/admin/buku-tamu/delete/'+bukuTamu.id">
                                <button type="submit" x-show="showConfirmDelete" class=" bg-red-600 hover:bg-red-800 text-white py-1 px-2 rounded mx-2">Konfirmasi Hapus</button>
                            </a>
                            <button x-show="showConfirmDelete" type="button" @click="showDetail= true; showConfirmDelete=false" class=" bg-gray-600 hover:bg-gray-800 text-white py-1 px-2 rounded mx-2">Batal</button>
                            <button x-show="showDetail" type="button" @click="showDetail= false; showConfirmDelete=false;" class=" bg-gray-600 hover:bg-gray-800 text-white py-1 px-2 rounded mx-2">Tutup</button>
                        </div>
                    </div>
                    <table class="w-full p-5 text-gray-700 border-3 border-black" x-show="!showDetail">

                        <head>
                            <tr>
                                <th class="border-2 text-teal-900 p-2">No</th>
                                <th class="border-2 text-teal-900 p-2">Nama Tamu</th>
                                <th class="border-2 text-teal-900 p-2">NIK</th>
                                <th class="border-2 text-teal-900 p-2">Check-In</th>
                                <th class="border-2 text-teal-900 p-2">Check-Out</th>
                                <th class="border-2 text-teal-900 p-2">Aksi</th>
                            </tr>
                        </head>

                        <body>
                            @for($i = 0 ; $i < count($semua); $i++) <tr x-show="filter=='SEMUA' || filter=='{{$semua[$i]->filter}}' || (filter=='MINGGU INI' && '{{$semua[$i]->filter}}'=='HARI INI') || (filter=='BULAN INI' && ('{{$semua[$i]->filter}}'=='HARI INI' || '{{$semua[$i]->filter}}'=='MINGGU INI'))">
                                <td class="border-2 p-2 text-center">{{ $i+1 }}</td>
                                <td class="border-2 p-2">{{ $semua[$i]->permintaan_bertamu->tamu->nama }}</td>
                                <td class="border-2 p-2">{{ $semua[$i]->permintaan_bertamu->tamu->nik }}</td>
                                <td class="border-2 p-2 text-center">{{ $semua[$i]->check_in }}</td>
                                <td class="border-2 p-2 text-center">{{ $semua[$i]->check_out }}</td>
                                <td class="border-2 p-2 text-center">
                                    <div>
                                        <button @click="bukuTamu={{ $semua[$i] }}; showDetail= !showDetail; showAlert=false" class="bg-teal-700 hover:bg-teal-900 text-white py-1 px-2 rounded">Detail</button>
                                    </div>
                                </td>
                                </tr>
                                @endfor
                        </body>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection