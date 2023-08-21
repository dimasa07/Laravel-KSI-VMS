@extends('layouts.layout_front_office')

@section('title','Front Office - Check-Out')

@section('content')
<!--Container-->
<div class="container w-full mx-auto pt-20">
    <div class="w-full px-4 md:px-0 md:mt-8 mb-16 text-gray-800 leading-normal">
        <div class="w-full p-3">
            <!--Table Card-->
            <div class="bg-white border rounded shadow">
                <div class="border-b px-3 py-6">
                    <h5 class="ml-5 text-3xl font-bold uppercase text-gray-600">Check-Out</h5>
                </div>
            </div>
        </div>

        <div class="w-full p-3" x-data="{ showDetail: false, confirmTolak:false, showAlert:true }">
            <!--Table Card-->
            <div class="bg-white border rounded shadow" x-data="{ permintaan: null }">
                <div class="p-5">
                    @if($pesan = Session::get('gagal'))
                    <div x-show="showAlert" class="bg-red-500 text-white w-full text-center rounded mb-6 p-1">
                        {{ $pesan }}
                    </div>
                    @endif
                    @if($pesan = Session::get('sukses'))
                    <div x-show="showAlert" class="bg-green-500 text-white w-full text-center rounded mb-6 p-1">
                        {{ $pesan }}
                    </div>
                    @endif
                    <form method="POST" @submit.prevent="submit()">
                        @csrf
                        <div style="display: none;" x-show="showDetail" class="relative pb-11 px-6" x-data="{ showConfirmTolak:false }">
                            <div x-data="{formData()}">
                                <table class="w-full p-5 text-gray-700">
                                    <tbody>
                                        <tr>
                                            <td class="w-40">Nama Tamu</td>
                                            <td class="w-6">:</td>
                                            <td x-text="permintaan.tamu.nama"></td>
                                            <td rowspan="7" class="text-right w-fit">
                                                <!-- <input name="id" x-model="formData.id" value="4"> -->
                                                <textarea x-model="formData.pesan_ditolak" x-show="showConfirmTolak" style="display:none" class="border-2 p-2" placeholder="Pesan ditolak..." id="pesan_ditolak" rows="6" cols="50" value="-" required></textarea>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="w-40">NIK</td>
                                            <td class="w-6">:</td>
                                            <td x-text="permintaan.tamu.nik"></td>

                                        </tr>
                                        <tr>
                                            <td class="w-40">Pegawai Dituju</td>
                                            <td class="w-6">:</td>
                                            <td x-text="permintaan.pegawai.nama"></td>
                                        </tr>
                                        <tr>
                                            <td class="w-40">Keperluan</td>
                                            <td class="w-6">:</td>
                                            <td x-text="permintaan.keperluan"></td>
                                        </tr>
                                        <tr>
                                            <td class="w-40">Waktu Bertamu</td>
                                            <td class="w-6">:</td>
                                            <td x-text="permintaan.waktu_bertamu"></td>
                                        </tr>
                                        <tr>
                                            <td class="w-40">Batas Waktu</td>
                                            <td class="w-6">:</td>
                                            <td x-text="permintaan.batas_waktu+' menit ( hinggal '+permintaan.maks+' )'"></td>
                                        </tr>
                                        <tr>
                                            <td class="w-40">Check-In</td>
                                            <td class="w-6">:</td>
                                            <td x-text="permintaan.buku_tamu.check_in"></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="inline-flex absolute right-0 bottom-0" x-data="{ showConfirmCheckOut : false }">
                                    <button type="button" href="#" x-show="!showConfirmCheckOut" @click="showConfirmCheckOut= !showConfirmCheckOut" class=" bg-green-600 hover:bg-green-800 text-white py-1 px-2 rounded mx-2">Check-Out</button>
                                    <a x-bind:href="window.location.origin+'/fo/buku-tamu/check-out/'+permintaan.buku_tamu.id">
                                        <button type="button" x-show="showConfirmCheckOut" class=" bg-green-600 hover:bg-green-800 text-white py-1 px-2 rounded mx-2">Konfirmasi Check-Out</button></a>
                                    <button x-show="showConfirmCheckOut" type="button" @click="showConfirmCheckOut=false" class=" bg-gray-600 hover:bg-gray-800 text-white py-1 px-2 rounded mx-2">Batal</button>
                                    <button type="button" @click="showDetail= !showDetail; showConfirmTolak=false; showConfirmCheckOut=false" class=" bg-gray-600 hover:bg-gray-800 text-white py-1 px-2 rounded mx-2">Tutup</button>
                                </div>
                            </div>
                        </div>

                        <table x-show="!showDetail" class="w-full p-5 text-gray-700 border-3 border-black">
                            <thead>
                                <tr>
                                    <th class="border-2 text-teal-900 p-2">No</th>
                                    <th class="border-2 text-teal-900 p-2">Nama Tamu</th>
                                    <th class="border-2 text-teal-900 p-2">NIK</th>
                                    <th class="border-2 text-teal-900 p-2">Pegawai dituju</th>
                                    <th class="border-2 text-teal-900 p-2">Check-In</th>
                                    <th class="border-2 text-teal-900 p-2">Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                @for($i = 0 ; $i < count($permintaan); $i++) <tr>
                                    <td class="border-2 p-2 text-center">{{ $i+1 }}</td>
                                    <td class="border-2 p-2">{{ $permintaan[$i]->tamu->nama }}</td>
                                    <td class="border-2 p-2">{{ $permintaan[$i]->tamu->nik }}</td>
                                    <td class="border-2 p-2">{{ $permintaan[$i]->pegawai->nama }}</td>
                                    <td class="border-2 p-2 text-center">{{ $permintaan[$i]->buku_tamu->check_in }}</td>
                                    <td class="border-2 p-2 text-center">
                                        <div>
                                            <button @click="permintaan={{ $permintaan[$i] }}; showDetail= !showDetail; showAlert=false" class="bg-teal-700 hover:bg-teal-900 text-white py-1 px-2 rounded">Detail</button>
                                        </div>
                                    </td>
                                    </tr>
                                    @endfor
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
            <!--/table Card-->
        </div>

    </div>
</div>
@endsection