@extends('layouts.layout_tamu')

@section('title','Tamu - Buat Permintaan')

@section('content')
<!--Container-->
<div class="container w-full pt-20 mx-auto">
    <div class="w-full px-4 mb-16 leading-normal text-gray-800 md:px-0 md:mt-8">
        <div class="w-full p-3">
            <!--Table Card-->
            <div class="bg-white border rounded shadow">
                <div class="px-3 py-6 border-b">
                    <h5 class="ml-5 text-3xl font-bold text-gray-600 uppercase">Buat Jadwal Bertamu</h5>
                </div>
            </div>
        </div>

        <div class="w-full p-3">
            <!--Table Card-->
            <div class="bg-white border rounded shadow">

                @if(session()->get('id')==0)
                <div class="p-5">
                    <h3 class="text-1xl">Isi <a class="text-blue-800 underline"
                            href="{{ route('tamu.profil') }}">profil</a> terlebih dahulu untuk bisa membuat permintaan.
                    </h3>
                </div>
                @else
                <div class="p-5">
                    @if($pesan = Session::get('gagal'))
                    <div class="w-full p-1 mb-6 text-center text-white bg-red-500 rounded">
                        {{ $pesan }}
                    </div>
                    @endif
                    @if($pesan = Session::get('sukses'))
                    <div class="w-full p-1 mb-6 text-center text-white bg-green-500 rounded">
                        {{ $pesan }}
                    </div>
                    @endif
                    <form method="POST" action="{{ route('tamu.permintaan.tambah') }}" x-data="{jabatan : ''}">
                        <div class="relative grid grid-cols-2">
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
                                <div class="mb-6 form-group">
                                    <label for="pegawai" class="inline-block mb-2 text-gray-700 form-label">Pegawai
                                        Dituju</label>
                                    <select name="id_pegawai" required
                                        class="bg-white form-control block w-full px-3 py-1.5 border border-gray-400"
                                        id="pegawai">
                                        <option :selected="jabatan==''" hidden disabled value="" :value="">PILIH PEGAWAI</option>
                                        @foreach($pegawai as $p)
                                        <option x-show="jabatan == '{{ $p->jabatan }}'" :selected="jabatan == '{{ $p->jabatan }}'" value="{{ $p->id }}">{{ $p->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="grid grid-cols-2 gap-2">
                                    <div class="mb-6 form-group">
                                        <label for="tanggal"
                                            class="inline-block mb-2 text-gray-700 form-label">Tanggal</label>
                                        <input required name="tanggal" type="date"
                                            class="form-control block w-full px-3 py-1.5 border border-gray-400"
                                            id="tanggal">
                                    </div>
                                    <div class="mb-6 form-group">
                                        <label for="waktu"
                                            class="inline-block mb-2 text-gray-700 form-label">Waktu</label>
                                        <input required name="waktu" type="time"
                                            class="form-control block w-full px-3 py-1.5 border border-gray-400"
                                            id="waktu">
                                    </div>
                                </div>
                            </div>

                            <div class="px-5">
                                <div class="h-full mb-6 form-group pb-14">
                                    <label for="keperluan"
                                        class="inline-block mb-2 text-gray-700 form-label">Keperluan</label>
                                    <textarea required name="keperluan" id="keperluan" cols="50"
                                        class="max-h-full min-h-full form-control block w-full px-3 py-1.5 border border-gray-400"></textarea>
                                </div>

                            </div>

                        </div>
                        <div class="mx-5 my-2">
                            <button class="w-full px-2 py-2 text-white bg-teal-700 rounded hover:bg-teal-900"
                                type="submit" value="Kirim">Kirim</button>
                        </div>
                    </form>
                </div>
                @endif
            </div>
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