@extends('layouts.layout_front_office')

@section('title','Front Office - Data Permintaan Bertamu')

@section('content')

<!--Container-->
<div class="container w-full mx-auto pt-20">
    <div class="w-full px-4 md:px-0 md:mt-8 mb-16 text-gray-800 leading-normal">
        <div class="w-full p-3">
            <!--Table Card-->
            <div class="bg-white border rounded shadow">
                <div class="border-b px-3 py-6">
                    <h5 class="ml-5 text-3xl font-bold uppercase text-gray-600">Data Jadwal Bertamu</h5>
                </div>
            </div>
        </div>

        <div class="w-full p-3" x-data="{showDetail:false,showFormEdit:false, dataEdit:null, showAlert:true}">
            <!--Table Card-->
            <div class="bg-white border rounded shadow" x-data="{ permintaan: null, filter:'SEMUA', no:0 }">
                <div class="inline-flex border-b p-3 w-full">
                    <select x-show="!showFormEdit" x-model="filter"
                        class="mx-4 py-1 px-4 bg-white border border-gray-600 rounded">
                        <option value="SEMUA">Semua</option>
                        <option value="BELUM DIPERIKSA">Belum Diperiksa</option>
                        <option value="DISETUJUI">Disetujui</option>
                        <option value="DITOLAK">Ditolak</option>
                    </select>
                    <button style="display: none;" x-show="showFormEdit" type="button" @click="showFormEdit = false"
                        class=" bg-gray-600 hover:bg-gray-800 text-white py-1 px-6 rounded mx-2">Batal</button>
                    <button style="display: none;" x-show="showFormEdit" type="button"
                        @click="showFormEdit = false; showDetail=false"
                        class=" bg-gray-600 hover:bg-gray-800 text-white py-1 px-6 rounded mx-2">Kembali Lihat
                        Tabel</button>
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

                <div x-show="!showFormEdit" class="p-5" x-data="{ permintaan:null, showConfirmDelete:false }">
                    <form method="POST" @submit.prevent="submit()">
                        @csrf
                        <div style="display: none;" x-show="showDetail" class="relative pb-11 px-6"
                            x-data="{ showConfirmTolak:false }">
                            <div x-data="{formData()}">
                                <table class="w-full p-5 text-gray-700">
                                    <tbody>
                                        <tr>
                                            <td class="w-40">Nama Tamu</td>
                                            <td class="w-6">:</td>
                                            <td x-text="permintaan.tamu.nama"></td>
                                            <td rowspan="7" class="text-right w-fit">
                                                <!-- <input name="id" x-model="formData.id" value="4"> -->
                                                <textarea x-model="formData.pesan_ditolak" x-show="showConfirmTolak"
                                                    style="display:none" class="border-2 p-2"
                                                    placeholder="Pesan ditolak..." id="pesan_ditolak" rows="6" cols="50"
                                                    value="-" required></textarea>
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
                                        <tr x-show="permintaan.front_office != null">
                                            <td class="w-40">Dikirim oleh</td>
                                            <td class="w-6">:</td>
                                            <td x-text="permintaan.front_office.nama"></td>
                                        </tr>
                                        <tr x-show="permintaan.front_office == null">
                                            <td class="w-40">Dikirim oleh</td>
                                            <td class="w-6">:</td>
                                            <td x-text="permintaan.tamu.nama"></td>
                                        </tr>
                                        <tr>
                                            <td class="w-40">Waktu Pengiriman</td>
                                            <td class="w-6">:</td>
                                            <td x-text="permintaan.waktu_pengiriman"></td>
                                        </tr>
                                        <tr>
                                            <td class="w-40">Status</td>
                                            <td class="w-6">:</td>
                                            <td x-text="permintaan.status"></td>
                                        </tr>
                                        <tr x-show="permintaan.status == 'DISETUJUI'">
                                            <td class="w-40">Batas Waktu</td>
                                            <td class="w-6">:</td>
                                            <td
                                                x-text="permintaan.batas_waktu+' menit ( hinggal '+permintaan.maks+' )'">
                                            </td>
                                        </tr>
                                        <tr x-show="permintaan.status == 'DITOLAK'">
                                            <td class="w-40">Pesan Ditolak</td>
                                            <td class="w-6">:</td>
                                            <td x-text="permintaan.pesan_ditolak"></td>
                                        </tr>
                                        <tr x-show="permintaan.status != 'BELUM DIPERIKSA'">
                                            <td class="w-40">Admin Pemeriksa</td>
                                            <td class="w-6">:</td>
                                            <td x-text="permintaan.admin.nama"></td>
                                        </tr>
                                        <tr x-show="permintaan.status != 'BELUM DIPERIKSA'">
                                            <td class="w-40">Waktu Pemeriksaan</td>
                                            <td class="w-6">:</td>
                                            <td x-text="permintaan.waktu_pemeriksaan"></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="inline-flex absolute right-0 bottom-0"
                                    x-data="{ showConfirmSetuju : false }">
                                    <div x-show="permintaan.front_office.id == {{ Session::get('id') }}">
                                        <button type="button" href="#" x-show="permintaan.status=='BELUM DIPERIKSA'"
                                            @click="showFormEdit=true; dataEdit=permintaan; showConfirmDelete=false"
                                            class=" bg-blue-600 hover:bg-blue-800 text-white py-1 px-2 rounded mx-2">Edit
                                            Data</button>
                                        <button x-show="permintaan.status=='BELUM DIPERIKSA' && !showConfirmDelete"
                                            @click="showConfirmDelete=true"
                                            class=" bg-red-600 hover:bg-red-800 text-white py-1 px-2 rounded mx-2">Hapus
                                            Data</button>
                                        <a x-bind:href="window.location.origin+'/fo/permintaan/delete/'+permintaan.id">
                                            <button type="button" @click="formData.id = permintaan.id;"
                                                x-show="showConfirmDelete"
                                                class=" bg-red-600 hover:bg-red-800 text-white py-1 px-2 rounded mx-2">Konfirmasi
                                                Hapus</button>
                                        </a>
                                        <button x-show="showConfirmDelete" type="button"
                                            @click="showConfirmDelete=false"
                                            class=" bg-gray-600 hover:bg-gray-800 text-white py-1 px-2 rounded mx-2">Batal</button>
                                    </div>
                                    <button type="button" @click="showDetail= !showDetail; showConfirmDelete=false"
                                        class=" bg-gray-600 hover:bg-gray-800 text-white py-1 px-2 rounded mx-2">Tutup</button>
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
                                    <!-- <th class="border-2 text-teal-900 p-2">Waktu Pengiriman</th> -->
                                    <th class="border-2 text-teal-900 p-2">Status</th>
                                    <th class="border-2 text-teal-900 p-2">Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                @for($i = 0 ; $i < count($semuaPermintaan); $i++) <tr
                                    x-show="(filter=='SEMUA' || filter=='{{$semuaPermintaan[$i]->status}}') && '{{$semuaPermintaan[$i]->status}}' != 'KADALUARSA' ">
                                    <td class="border-2 p-2 text-center">{{ $i+1 }}</td>
                                    <td class="border-2 p-2">{{ $semuaPermintaan[$i]->tamu->nama }}</td>
                                    <td class="border-2 p-2">{{ $semuaPermintaan[$i]->tamu->nik }}</td>
                                    <td class="border-2 p-2">{{ $semuaPermintaan[$i]->pegawai->nama }}</td>
                                    <!-- <td class="border-2 p-2 text-center">{{ $semuaPermintaan[$i]->waktu_pengiriman }}</td> -->
                                    <td class="border-2 p-2 text-center">{{ $semuaPermintaan[$i]->status }}</td>
                                    <td class="border-2 p-2 text-center">
                                        <div>
                                            <button
                                                @click="permintaan={{ $semuaPermintaan[$i] }}; showDetail= !showDetail; showAlert=false"
                                                class="bg-teal-700 hover:bg-teal-900 text-white py-1 px-2 rounded">Detail</button>
                                        </div>
                                    </td>
                                    </tr>
                                    @endfor
                            </tbody>
                        </table>
                    </form>
                </div>

                <div style="display: none;" x-show="showFormEdit" class="p-5">
                    <form method="POST" action="{{ route('fo.permintaan.update') }}" x-data="{jabatan : ''}">
                        @csrf
                        <div class="border-b p-3">
                            <h5 class="font-bold uppercase text-gray-600">Form Data Tamu</h5>
                        </div>
                        <div class="p-5">
                            <div class="grid grid-cols-2 relative">
                                <div class="px-5">
                                    <div class="form-group mb-6">
                                        <label for="nama" class="form-label inline-block mb-2 text-gray-700">Nama
                                            Tamu</label>
                                        <input required :value="dataEdit.tamu.nama" type="text"
                                            class="form-control block w-full px-3 py-1.5 border border-gray-400"
                                            name="nama" id="nama">
                                        <!-- <small id="emailHelp" class="block mt-1 text-xs text-gray-600">We'll never share your email with anyone
                                        else.</small> -->
                                    </div>
                                    <div class="form-group mb-6">
                                        <label for="nik" class="form-label inline-block mb-2 text-gray-700">NIK</label>
                                        <input required :value="dataEdit.tamu.nik" name="nik" type="text"
                                            class="form-control block w-full px-3 py-1.5 border border-gray-400"
                                            id="nik">
                                    </div>
                                    <div class="form-group mb-6">
                                        <label for="no_telepon" class="form-label inline-block mb-2 text-gray-700">No.
                                            Telepon <small
                                                class=" mt-1 text-xs text-gray-600">(optional)</small></label>
                                        <input :value="dataEdit.tamu.no_telepon" name="no_telepon" type="text"
                                            class="form-control block w-full px-3 py-1.5 border border-gray-400"
                                            id="no_telepon">
                                    </div>

                                </div>

                                <div class="px-5">
                                    <div class="form-group mb-6">
                                        <label for="email" class="form-label inline-block mb-2 text-gray-700">Email
                                            <small class=" mt-1 text-xs text-gray-600">(optional)</small></label>
                                        <input :value="dataEdit.tamu.email" name="email" type="email"
                                            class="form-control block w-full px-3 py-1.5 border border-gray-400"
                                            id="email">

                                    </div>
                                    <div class="form-group mb-6 h-4/6 pb-14">
                                        <label for="alamat" class="form-label inline-block mb-2 text-gray-700">Alamat
                                            <small
                                                class=" mt-1 text-xs text-gray-600">(optional)</small></label></label>
                                        <textarea :value="dataEdit.tamu.alamat" name="alamat" id="alamat" cols="50"
                                            class="max-h-full min-h-full form-control block w-full px-3 py-1.5 border border-gray-400"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="border-b p-3">
                            <h5 class="font-bold uppercase text-gray-600">Form Data Permintaan</h5>
                        </div>
                        <div class="p-5 grid grid-cols-2 relative">
                            <div class="px-5">
                                <div class="mb-6 form-group">
                                    <label for="jabatan" class="inline-block mb-2 text-gray-700 form-label">Filter
                                        Jabatan Pegawai</label>
                                    <select x-model="jabatan" name="jabatan"
                                        class="bg-white form-control block w-full px-3 py-1.5 border border-gray-400"
                                        id="jabatan">
                                        <option selected hidden disabled value="" :value="">PILIH JABATAN</option>
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
                                    </select>
                                </div>
                                <div class="form-group mb-6">
                                    <label for="pegawai" class="form-label inline-block mb-2 text-gray-700">Pegawai
                                        Dituju</label>
                                    <select name="id_pegawai"
                                        class="bg-white form-control block w-full px-3 py-1.5 border border-gray-400"
                                        id="pegawai">
                                        <option selected x-text="dataEdit.pegawai.nama" disabled hidden></option>
                                        @foreach($pegawai as $p)
                                        <option x-show="jabatan == '{{ $p->jabatan }}'" value="{{ $p->id }}">{{ $p->nama }}</option>
                                        @endforeach
                                    </select> 
                                </div>
                                <div class="grid grid-cols-2 gap-2">
                                    <div class="form-group mb-6">
                                        <label for="tanggal"
                                            class="form-label inline-block mb-2 text-gray-700">Tanggal</label>
                                        <input required name="tanggal" type="date"
                                            class="form-control block w-full px-3 py-1.5 border border-gray-400"
                                            id="tanggal">
                                    </div>
                                    <div class="form-group mb-6">
                                        <label for="waktu"
                                            class="form-label inline-block mb-2 text-gray-700">Waktu</label>
                                        <input required name="waktu" type="time"
                                            class="form-control block w-full px-3 py-1.5 border border-gray-400"
                                            id="waktu">
                                    </div>
                                </div>
                            </div>

                            <div class="px-5">
                                <div class="form-group mb-6 h-full pb-14">
                                    <label for="keperluan"
                                        class="form-label inline-block mb-2 text-gray-700">Keperluan</label>
                                    <textarea :value="dataEdit.keperluan" required name="keperluan" id="keperluan"
                                        cols="50"
                                        class="max-h-full min-h-full form-control block w-full px-3 py-1.5 border border-gray-400"></textarea>
                                </div>

                            </div>

                        </div>
                        <div class="my-2 mx-5">
                            <input type="hidden" :value="dataEdit.id" name="id">
                            <button class="w-full py-2 bg-green-600 hover:bg-green-800 text-white px-2 rounded"
                                type="submit" value="Kirim">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>

            </div>
            <!--/table Card-->
        </div>

    </div>
</div>
<script>
    var timepicker = new TimePicker('waktu', {
        lang: 'en',
        theme: 'dark'
    });
    timepicker.on('change', function(evt) {

        var value = ((evt.hour < 10) ? '0' + evt.hour : evt.hour || '00') + ':' + (evt.minute || '00');
        evt.element.value = value;

    });
</script>
@endsection