@extends('layouts.layout_front_office')

@section('title','Front Office - Data Tamu')

@section('content')
<!--Container-->
<div class="container w-full mx-auto pt-20">
    <div class="w-full px-4 md:px-0 md:mt-8 mb-16 text-gray-800 leading-normal">
        <div class="w-full p-3">
            <!--Table Card-->
            <div class="bg-white border rounded shadow">
                <div class="border-b px-3 py-6">
                    <h5 class="ml-5 text-3xl font-bold uppercase text-gray-600">Data Tamu</h5>
                </div>
            </div>
        </div>

        <div class="w-full p-3">
            <!--Table Card-->
            <div class="bg-white border rounded shadow">
                <!-- <div class="border-b p-3">
                    <h5 class="font-bold uppercase text-gray-600">Sudah Memiliki Akun</h5>
                </div> -->
                <div class="p-5" x-data="{ tamu:null,showDetail:false,showConfirmDelete:false }">
                    <div style="display: none;" x-show="showDetail" class="relative pb-11 px-6">
                        <div x-data="{formData()}">
                            <table class="w-full p-5 text-gray-700">
                                <tbody>
                                    <tr>
                                        <td class="w-40">Nama Tamu</td>
                                        <td class="w-6">:</td>
                                        <td x-text="tamu.nama"></td>
                                    </tr>
                                    <tr>
                                        <td class="w-40">NIK</td>
                                        <td class="w-6">:</td>
                                        <td x-text="tamu.nik"></td>

                                    </tr>
                                    <tr>
                                        <td class="w-40">No. Telepon</td>
                                        <td class="w-6">:</td>
                                        <td x-text="tamu.no_telepon"></td>
                                    </tr>
                                    <tr>
                                        <td class="w-40">Email</td>
                                        <td class="w-6">:</td>
                                        <td x-text="tamu.email"></td>
                                    </tr>
                                    <tr>
                                        <td class="w-40">Alamat</td>
                                        <td class="w-6">:</td>
                                        <td x-text="tamu.alamat"></td>
                                    </tr>
                                    <!-- <tr>
                                        <td class="w-40">Username</td>
                                        <td class="w-6">:</td>
                                        <td x-text="tamu.akun.username"></td>
                                    </tr> -->
                                </tbody>
                            </table>
                            <div class="inline-flex absolute right-0 bottom-0" x-data="{ showConfirmSetuju : false }">
                                <!-- <button type="button" href="#" x-show="!showConfirmSetuju" @click="showConfirmSetuju= !showConfirmSetuju" class=" bg-green-600 hover:bg-green-800 text-white py-1 px-2 rounded mx-2">Setujui</button>
                                <a x-bind:href="window.location.origin+'/admin/permintaan/setujui/'+permintaan.id">
                                    <button type="button" x-show="showConfirmSetuju" class=" bg-green-600 hover:bg-green-800 text-white py-1 px-2 rounded mx-2">Konfirmasi Setuju</button></a> -->
                                <!-- <button x-show="!showConfirmDelete" @click="showConfirmDelete= !showConfirmDelete" class=" bg-red-600 hover:bg-red-800 text-white py-1 px-2 rounded mx-2">Hapus Tamu</button>

                                <a x-bind:href="window.location.origin+'/admin/tamu/delete/'+tamu.id">
                                    <button type="submit" @click="formData.id = permintaan.id;" x-show="showConfirmDelete" class=" bg-red-600 hover:bg-red-800 text-white py-1 px-2 rounded mx-2">Konfirmasi Hapus</button>
                                </a> -->
                                <button type="button" @click="showDetail= !showDetail; showConfirmDelete=false; showConfirmSetuju=false" class=" bg-gray-600 hover:bg-gray-800 text-white py-1 px-2 rounded mx-2">Tutup</button>
                            </div>
                        </div>
                    </div>

                    <table class="w-full p-5 text-gray-700 border-3 border-black" x-show="!showDetail">
                        <thead>
                            <tr>
                                <th class="border-2 text-teal-900 p-2">No</th>
                                <th class="border-2 text-teal-900 p-2">Nama Tamu</th>
                                <th class="border-2 text-teal-900 p-2">NIK</th>
                                <!-- <th class="border-2 text-teal-900 p-2">Username</th> -->
                                <th class="border-2 text-teal-900 p-2">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @for($i = 0 ; $i < count($tamu); $i++) <tr>
                                <td class="border-2 p-2 text-center">{{ $i+1 }}</td>
                                <td class="border-2 p-2">{{ $tamu[$i]->nama }}</td>
                                <td class="border-2 p-2">{{ $tamu[$i]->nik }}</td>
                                <td class="border-2 p-2 text-center">
                                    <div>
                                        <button @click="tamu={{ $tamu[$i] }}; showDetail= !showDetail" class="bg-teal-700 hover:bg-teal-900 text-white py-1 px-2 rounded">Detail</button>
                                    </div>
                                </td>
                                </tr>
                                @endfor
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!--/table Card-->
    </div>
</div>

@endsection