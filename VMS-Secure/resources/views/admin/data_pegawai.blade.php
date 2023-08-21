@extends('layouts.layout_admin')

@section('title','Admin - Data Pegawai')

@section('content')
<!--Container-->
<div class="container w-full mx-auto pt-20">
    <div class="w-full px-4 md:px-0 md:mt-8 mb-16 text-gray-800 leading-normal">
        <div class="w-full p-3">
            <!--Table Card-->
            <div class="bg-white border rounded shadow">
                <div class="border-b px-3 py-6">
                    <h5 class="ml-5 text-3xl font-bold uppercase text-gray-600">Data Pegawai</h5>
                </div>
            </div>
        </div>
        <div class="w-full p-3">
            <!--Table Card-->
            <div class="bg-white border rounded shadow" x-data="{showFormTambah:false,showFormEdit:false,showDetail:false,showAlert:true}">
                <div class="inline-flex border-b p-3 w-full" x-show="!showFormTambah && !showFormEdit &&!showDetail">
                    <button @click="showFormTambah=true; showAlert=false; " class="bg-blue-600 rounded ml-4 py-1 px-10 text-white hover:bg-blue-800">Tambah</button>
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
                <div class="inline-flex placeholder:border-b p-3" x-show="showFormTambah">
                    <h5 class="font-bold uppercase text-gray-600">Tambah Data Pegawai</h5>
                </div>
                <div class="p-5" x-data="{ pegawai:null,showConfirmDelete:false }">

                    <form x-show="!showFormTambah" method="POST" @submit.prevent="submit()">
                        <div style="display: none;" x-show="showDetail || showFormEdit" class="relative pb-11 px-6">
                            <table class="w-full p-5 text-gray-700" x-show="!showFormEdit && showDetail">
                                <tbody>
                                    <tr>
                                        <td class="w-40">Nama Pegawai</td>
                                        <td class="w-6">:</td>
                                        <td x-text="pegawai.nama"></td>
                                    </tr>
                                    <tr>
                                        <td class="w-40">NIP</td>
                                        <td class="w-6">:</td>
                                        <td x-text="pegawai.nip"></td>

                                    </tr>
                                    <tr>
                                        <td class="w-40">Jabatan</td>
                                        <td class="w-6">:</td>
                                        <td x-text="pegawai.jabatan"></td>

                                    </tr>
                                    <tr>
                                        <td class="w-40">No. Telepon</td>
                                        <td class="w-6">:</td>
                                        <td x-text="pegawai.no_telepon"></td>
                                    </tr>
                                    <tr>
                                        <td class="w-40">Email</td>
                                        <td class="w-6">:</td>
                                        <td x-text="pegawai.email"></td>
                                    </tr>
                                    <tr>
                                        <td class="w-40">Alamat</td>
                                        <td class="w-6">:</td>
                                        <td x-text="pegawai.alamat"></td>
                                    </tr>
                                    <!-- <tr>
                                    <td class="w-40">Username</td>
                                    <td class="w-6">:</td>
                                    <td x-text="pegawai.akun.username"></td>
                                </tr> -->
                                </tbody>
                            </table>
                            <table style="display: none;" class="w-full p-5 text-gray-700" x-show="showFormEdit">
                                <tbody>
                                    <tr>
                                        <td class="w-40">Nama Pegawai</td>
                                        <td class="w-6">:</td>
                                        <td><input required x-model="formData.nama" class="px-1 border border-gray-600 w-full" type="text" name="nama" :value="pegawai.nama"></td>
                                    </tr>
                                    <tr>
                                        <td class="w-40">NIP</td>
                                        <td class="w-6">:</td>
                                        <td><input disabled x-model="formData.nip" class="px-1 border border-gray-600 w-full" type="text" name="nip" :value="pegawai.nip"></td>

                                    </tr>
                                    <tr>
                                        <td class="w-40">Jabatan</td>
                                        <td class="w-6">:</td>
                                        <td><select x-model="formData.jabatan" name="jabatan" required
                                            class="bg-white form-control block w-full px-3 py-0.5 border border-black"
                                            id="jabatan">
                                            <option selected x-text="pegawai.jabatan" disabled hidden :value="pegawai.jabatan"></option>
                                            <option>ADMIN</option>
                                            <option>FRONT OFFICE</option>
                                            <option>KEPALA DINAS</option>
                                            <option>STAFF</option>
                                            <option disabled>- SEKRETARIAT </option>
                                            <option>KEPALA SEKRETARIAT</option>
                                            <option>SUB BAGIAN UMUM DAN KEPEGAWAIAN</option>
                                            <option>PERENCANA</option>
                                            <option>SUB BAGIAN KEUANGAN</option>
                                            <option disabled>- BIDANG INFORMASI KOMUNIKASI PUBLIK</option>
                                            <option>KEPALA BIDANG INFORMASI KOMUNIKASI PUBLIK</option>
                                            <option>PRANATA HUBUNGAN MASYARAKAT BIDANG INFORMASI KOMUNIKASI PUBLIK</option>
                                            <option disabled>- BIDANG PERSANDIAN</option>
                                            <option>KEPALA BIDANG PERSANDIAN</option>
                                            <option>SANDIMAN BIDANG PERSANDIAN</option>
                                            <option disabled>- BIDANG TEKNOLOGI INFOMASI DAN KOMUNIKASI</option>
                                            <option>KEPALA BIDANG TEKNOLOGI INFOMASI DAN KOMUNIKASI</option>
                                            <option>PRANATA KOMPUTER BIDANG TEKNOLOGI INFOMASI DAN KOMUNIKASI</option>
                                            <option disabled>- BIDANG APLIKASI INFORMATIKA</option>
                                            <option>KEPALA BIDANG APLIKASI INFORMATIKA</option>
                                            <option>PRANATA KOMPUTER BIDANG APLIKASI INFORMATIKA</option>
                                            <option disabled>- BIDANG STATISTIK</option>
                                            <option>KEPALA BIDANG STATISTIK</option>
                                            <option>STATISTISI BIDANG STATISTIK</option>
                                        </select></td>

                                    </tr>
                                    <tr>
                                        <td class="w-40">No. Telepon</td>
                                        <td class="w-6">:</td>
                                        <td><input x-model="formData.no_telepon" class="px-1 border border-gray-600 w-full" type="text" name="no_telepon" :value="pegawai.no_telepon"></td>
                                    </tr>
                                    <tr>
                                        <td class="w-40">Email</td>
                                        <td class="w-6">:</td>
                                        <td><input x-model="formData.email" class="px-1 border border-gray-600 w-full" type="text" name="email" :value="pegawai.email"></td>
                                    </tr>
                                    <tr>
                                        <td class="w-40">Alamat</td>
                                        <td class="w-6">:</td>
                                        <td><input x-model="formData.alamat" class="px-1 border border-gray-600 w-full" type="text" name="alamat" :value="pegawai.alamat"></td>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="inline-flex absolute right-0 bottom-0">
                                <button type="button" x-show="!showFormEdit" @click="showFormEdit= true; showDetail = false; showConfirmDelete=false;" class=" bg-blue-600 hover:bg-blue-800 text-white py-1 px-2 rounded mx-2">Edit Data</button>

                                <!-- <a x-bind:href="window.location.origin+'/admin/profil/update'"> -->
                                <button style="display: none;" type="submit" @click="formData.id=pegawai.id; formData.nip=pegawai.nip" x-show="showFormEdit" class=" bg-green-600 hover:bg-green-800 text-white py-1 px-2 rounded mx-2">Simpan Perubahan</button>
                                <!-- </a> -->
                                <button x-show="!showConfirmDelete && !showFormEdit" @click="showConfirmDelete= !showConfirmDelete" class=" bg-red-600 hover:bg-red-800 text-white py-1 px-2 rounded mx-2">Hapus Pegawai</button>

                                <a x-bind:href="window.location.origin+'/admin/pegawai/delete/'+pegawai.id">
                                    <button type="button" x-show="showConfirmDelete" class=" bg-red-600 hover:bg-red-800 text-white py-1 px-2 rounded mx-2">Konfirmasi Hapus</button>
                                </a>
                                <button x-show="showFormEdit || showConfirmDelete" type="button" @click="showDetail= true; showFormEdit=false; showConfirmDelete=false" class=" bg-gray-600 hover:bg-gray-800 text-white py-1 px-2 rounded mx-2">Batal</button>
                                <button x-show="showDetail || showFormEdit" type="button" @click="showDetail= false; showConfirmDelete=false; showFormEdit=false" class=" bg-gray-600 hover:bg-gray-800 text-white py-1 px-2 rounded mx-2">Tutup</button>
                            </div>
                        </div>
                    </form>
                    <form method="POST" @submit.prevent="tambah()">
                        <div style="display: none;" x-show="showFormTambah" class="relative pb-11 px-6">
                            <table class="w-full p-5 text-gray-700">
                                <tbody>
                                    <tr>
                                        <td class="w-40">Nama Pegawai</td>
                                        <td class="w-6">:</td>
                                        <td><input required x-model="formData.nama" class="px-1 border border-gray-600 w-full" type="text" name="nama"></td>
                                    </tr>
                                    <tr>
                                        <td class="w-40">NIP</td>
                                        <td class="w-6">:</td>
                                        <td><input required x-model="formData.nip" class="px-1 border border-gray-600 w-full" type="text" name="nip"></td>

                                    </tr>
                                    <tr>
                                        <td class="w-40">Jabatan</td>
                                        <td class="w-6">:</td>
                                        <td><select x-model="formData.jabatan" name="jabatan" required
                                            class="bg-white form-control block w-full px-3 py-0.5 border border-black"
                                            id="jabatan">
                                            <option selected hidden disabled :value="" value="">PILIH JABATAN</option>
                                            <option>ADMIN</option>
                                            <option>FRONT OFFICE</option>
                                            <option>KEPALA DINAS</option>
                                            <option>STAFF</option>
                                            <option disabled>- SEKRETARIAT </option>
                                            <option>KEPALA SEKRETARIAT</option>
                                            <option>SUB BAGIAN UMUM DAN KEPEGAWAIAN</option>
                                            <option>PERENCANA</option>
                                            <option>SUB BAGIAN KEUANGAN</option>
                                            <option disabled>- BIDANG INFORMASI KOMUNIKASI PUBLIK</option>
                                            <option>KEPALA BIDANG INFORMASI KOMUNIKASI PUBLIK</option>
                                            <option>PRANATA HUBUNGAN MASYARAKAT BIDANG INFORMASI KOMUNIKASI PUBLIK</option>
                                            <option disabled>- BIDANG PERSANDIAN</option>
                                            <option>KEPALA BIDANG PERSANDIAN</option>
                                            <option>SANDIMAN BIDANG PERSANDIAN</option>
                                            <option disabled>- BIDANG TEKNOLOGI INFOMASI DAN KOMUNIKASI</option>
                                            <option>KEPALA BIDANG TEKNOLOGI INFOMASI DAN KOMUNIKASI</option>
                                            <option>PRANATA KOMPUTER BIDANG TEKNOLOGI INFOMASI DAN KOMUNIKASI</option>
                                            <option disabled>- BIDANG APLIKASI INFORMATIKA</option>
                                            <option>KEPALA BIDANG APLIKASI INFORMATIKA</option>
                                            <option>PRANATA KOMPUTER BIDANG APLIKASI INFORMATIKA</option>
                                            <option disabled>- BIDANG STATISTIK</option>
                                            <option>KEPALA BIDANG STATISTIK</option>
                                            <option>STATISTISI BIDANG STATISTIK</option>
                                        </select></td>

                                    </tr>
                                    <tr>
                                        <td class="w-40">No. Telepon</td>
                                        <td class="w-6">:</td>
                                        <td><input x-model="formData.no_telepon" class="px-1 border border-gray-600 w-full" type="text" name="no_telepon"></td>
                                    </tr>
                                    <tr>
                                        <td class="w-40">Email</td>
                                        <td class="w-6">:</td>
                                        <td><input x-model="formData.email" class="px-1 border border-gray-600 w-full" type="text" name="email"></td>
                                    </tr>
                                    <tr>
                                        <td class="w-40">Alamat</td>
                                        <td class="w-6">:</td>
                                        <td><input x-model="formData.alamat" class="px-1 border border-gray-600 w-full" type="text" name="alamat"></td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="inline-flex absolute right-0 bottom-0">
                                <!-- <button style="display: none;" type="submit" @click="formData.id=pegawai.id; formData.nip=pegawai.nip" x-show="showFormEdit" class=" bg-green-600 hover:bg-green-800 text-white py-1 px-2 rounded mx-2">Simpan Perubahan</button>
                                <button x-show="!showConfirmDelete && !showFormEdit" @click="showConfirmDelete= !showConfirmDelete" class=" bg-red-600 hover:bg-red-800 text-white py-1 px-2 rounded mx-2">Hapus Pegawai</button>
                                
                                <a x-bind:href="window.location.origin+'/admin/pegawai/delete/'+pegawai.id">
                                    <button type="submit" x-show="showConfirmDelete" class=" bg-red-600 hover:bg-red-800 text-white py-1 px-2 rounded mx-2">Konfirmasi Hapus</button>
                                </a> -->
                                <!-- <button x-show="showFormEdit || showConfirmDelete" type="button" @click="showDetail= true; showFormEdit=false; showConfirmDelete=false" class=" bg-gray-600 hover:bg-gray-800 text-white py-1 px-2 rounded mx-2">Batal</button> -->
                                <button type="submit" class="bg-green-600 hover:bg-green-800 text-white py-1 px-2 rounded mx-2">Simpan</button>
                                <button type="button" @click="showFormTambah=false" class=" bg-gray-600 hover:bg-gray-800 text-white py-1 px-2 rounded mx-2">Batal</button>
                            </div>
                        </div>
                    </form>
                    <table class="w-full p-5 text-gray-700 border-3 border-black" x-show="!showDetail && !showFormEdit && !showFormTambah">
                        <thead>
                            <tr>
                                <th class="border-2 text-teal-900 p-2">No</th>
                                <th class="border-2 text-teal-900 p-2">Nama Pegawai</th>
                                <th class="border-2 text-teal-900 p-2">NIP</th>
                                <th class="border-2 text-teal-900 p-2">Jabatan</th>
                                <th class="border-2 text-teal-900 p-2">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @for($i = 0 ; $i < count($pegawai); $i++) <tr>
                                <td class="border-2 p-2 text-center">{{ $i+1 }}</td>
                                <td class="border-2 p-2">{{ $pegawai[$i]->nama }}</td>
                                <td class="border-2 p-2">{{ $pegawai[$i]->nip }}</td>
                                <td class="border-2 p-2">{{ $pegawai[$i]->jabatan }}</td>
                                <td class="border-2 p-2 text-center">
                                    <div>
                                        <button @click="pegawai={{ $pegawai[$i] }}; showDetail= !showDetail; showAlert=false" class="bg-teal-700 hover:bg-teal-900 text-white py-1 px-2 rounded">Detail</button>
                                    </div>
                                </td>
                                </tr>
                                @endfor
                        </tbody>
                    </table>
                </div>
            </div>
            <!--/table Card-->
        </div>
    </div>
</div>
<script>
    function submit() {
        $.ajax({
            type: 'POST',
            url: window.location.origin + "/admin/pegawai/update",
            data: {
                'id': formData.id,
                'nama': formData.nama,
                'nip': formData.nip,
                'jabatan': formData.jabatan,
                'no_telepon': formData.no_telepon,
                'email': formData.email,
                'alamat': formData.alamat
            },
            success: function(success) {
                console.log(success.sukses);
                location.reload();
                // if(success.sukses){
                //     $('#sukses').css('display','');
                // }
            },
            error: function(error) {
                console.log(error);
                // document.body.innerHTML = success;
                // location.reload();
            }
        });
    }

    function tambah() {
        $.ajax({
            type: 'POST',
            url: window.location.origin + "/admin/pegawai/tambah",
            data: {
                '_token' : '{{ csrf_token() }}',
                'nama': formData.nama,
                'nip': formData.nip,
                'jabatan': formData.jabatan,
                'no_telepon': formData.no_telepon,
                'email': formData.email,
                'alamat': formData.alamat
            },
            headers: {
                'X-XSRF-TOKEN': '{{ Cookie::get('XSRF-TOKEN') }}'
            },
            success: function(success) {
                console.log(success.sukses);
                location.reload();
            },
            error: function(error) {
                console.log(error);
            }
        });
    }

    function formData() {
        return {
            formData: {
                id: 0,
                nama: '',
                nip: '',
                jabatan: '',
                no_telepon: '',
                email: '',
                alamat: ''
            }
        }
    }
</script>
@endsection