@extends('layouts.layout_admin')
@section('title','Admin - Dasbor')
@section('dasbor','text-blue-600')
@section('content')
<!--Container-->
<div class="container w-full mx-auto pt-20">
    <div class="w-full px-4 md:px-0 md:mt-8 mb-16 text-gray-800 leading-normal">

        <!--Console Content-->

        <div class="flex flex-wrap">
            <div class="w-full md:w-1/2 xl:w-1/3 p-3">
                <!--Metric Card-->
                <div class="bg-white border rounded shadow p-2">
                    <div class="flex flex-row items-center">
                        <div class="flex-shrink pr-4">
                            <div class="rounded p-3 bg-green-600"><i class="fa fa-envelope fa-2x fa-fw fa-inverse"></i></div>
                        </div>
                        <div class="flex-1 text-right md:text-center">
                            <h5 class="font-bold uppercase text-gray-500">Total Permintaan Bertamu</h5>
                            <h3 class="font-bold text-3xl">{{ $totalPermintaan }}</h3>
                        </div>
                    </div>
                </div>
                <!--/Metric Card-->
            </div>
            <div class="w-full md:w-1/2 xl:w-1/3 p-3">
                <!--Metric Card-->
                <div class="bg-white border rounded shadow p-2">
                    <div class="flex flex-row items-center">
                        <div class="flex-shrink pr-4">
                            <div class="rounded p-3 bg-indigo-600"><i class="fas fa-check fa-2x fa-fw fa-inverse"></i></div>
                        </div>
                        <div class="flex-1 text-right md:text-center">
                            <h5 class="font-bold uppercase text-gray-500">Permintaan disetujui</h5>
                            <h3 class="font-bold text-3xl">{{ $permintaanDisetujui }}</h3>
                        </div>
                    </div>
                </div>
                <!--/Metric Card-->
            </div>
            <div class="w-full md:w-1/2 xl:w-1/3 p-3">
                <!--Metric Card-->
                <div class="bg-white border rounded shadow p-2">
                    <div class="flex flex-row items-center">
                        <div class="flex-shrink pr-4">
                            <div class="rounded p-3 bg-pink-600"><i class="fas fa-book fa-2x fa-fw fa-inverse"></i></div>
                        </div>
                        <div class="flex-1 text-right md:text-center">
                            <h5 class="font-bold uppercase text-gray-500">Laporan Hari Ini</h5>
                            <h3 class="font-bold text-3xl">{{ $laporanHariIni }}</h3>
                        </div>
                    </div>
                </div>
                <!--/Metric Card-->
            </div>
            <div class="w-full md:w-1/2 xl:w-1/3 p-3">
                <!--Metric Card-->
                <div class="bg-white border rounded shadow p-2">
                    <div class="flex flex-row items-center">
                        <div class="flex-shrink pr-4">
                            <div class="rounded p-3 bg-teal-700"><i class="fas fa-server fa-2x fa-fw fa-inverse"></i></div>
                        </div>
                        <div class="flex-1 text-right md:text-center">
                            <h5 class="font-bold uppercase text-gray-500">Permintaan belum diperiksa</h5>
                            <h3 class="font-bold text-3xl">{{ $permintaanBelumDiperiksa }}</h3>
                        </div>
                    </div>
                </div>
                <!--/Metric Card-->
            </div>
            <div class="w-full md:w-1/2 xl:w-1/3 p-3">
                <!--Metric Card-->
                <div class="bg-white border rounded shadow p-2">
                    <div class="flex flex-row items-center">
                        <div class="flex-shrink pr-4">
                            <div class="rounded p-3 bg-red-600"><i class="fas fa-inbox fa-2x fa-fw fa-inverse"></i></div>
                        </div>
                        <div class="flex-1 text-right md:text-center">
                            <h5 class="font-bold uppercase text-gray-500">Permintaan ditolak</h5>
                            <h3 class="font-bold text-3xl">{{ $permintaanDitolak }}</h3>
                        </div>
                    </div>
                </div>
                <!--/Metric Card-->
            </div>
            <div class="w-full md:w-1/2 xl:w-1/3 p-3">
                <!--Metric Card-->
                <div class="bg-white border rounded shadow p-2">
                    <div class="flex flex-row items-center">
                        <div class="flex-shrink pr-4">
                            <div class="rounded p-3 bg-yellow-600"><i class="fas fa-book fa-2x fa-fw fa-inverse"></i></div>
                        </div>
                        <div class="flex-1 text-right md:text-center">
                            <h5 class="font-bold uppercase text-gray-500">Total Laporan</h5>
                            <h3 class="font-bold text-3xl">{{ $totalLaporan }}</h3>
                        </div>
                    </div>
                </div>
                <!--/Metric Card-->
            </div>
        </div>

        <!--Divider-->
        <hr class="border-b-2 border-gray-400 my-8 mx-4">

        <div class="flex flex-row flex-wrap flex-grow mt-2">
            <div class="w-full md:w-1/2 p-3">
                <!--Graph Card-->
                <div class="bg-white border rounded shadow">
                    <div class="border-b p-3">
                        <h5 class="font-bold uppercase text-gray-600">Permintaan hari ini</h5>
                    </div>
                    <div class="p-5">
                        <table class="w-full p-5 text-gray-700 border-3 border-black">

                            <head>
                                <tr>
                                    <th class="border-2 text-teal-900 p-2">No</th>
                                    <th class="border-2 text-teal-900 p-2">Nama Tamu</th>
                                    <th class="border-2 text-teal-900 p-2">NIK</th>
                                    <th class="border-2 text-teal-900 p-2">Waktu Pengiriman</th>
                                </tr>
                            </head>

                            <body>
                                @for($i = 0 ; $i < count($dataPermintaanHariIni); $i++) <tr>
                                    <td class="border-2 p-2 text-center">{{ $i+1 }}</td>
                                    <td class="border-2 p-2">{{ $dataPermintaanHariIni[$i]->tamu->nama }}</td>
                                    <td class="border-2 p-2">{{ $dataPermintaanHariIni[$i]->tamu->nik }}</td>
                                    <td class="border-2 p-2 text-center">{{ $dataPermintaanHariIni[$i]->waktu_pengiriman }}</td>
                                    </tr>
                                    @endfor
                            </body>
                        </table>
                    </div>
                </div>
                <!--/Graph Card-->
            </div>

            <div class="w-full md:w-1/2 p-3">
                <!--Graph Card-->
                <div class="bg-white border rounded shadow">
                    <div class="border-b p-3">
                        <h5 class="font-bold uppercase text-gray-600">Laporan hari ini</h5>
                    </div>
                    <div class="p-5">
                        <table class="w-full p-5 text-gray-700 border-3 border-black">

                            <head>
                                <tr>
                                    <th class="border-2 text-teal-900 p-2">No</th>
                                    <th class="border-2 text-teal-900 p-2">Nama Tamu</th>
                                    <th class="border-2 text-teal-900 p-2">NIK</th>
                                    <th class="border-2 text-teal-900 p-2">Check-in</th>
                                </tr>
                            </head>

                            <body>
                                @for($i = 0 ; $i < count($dataLaporanHariIni); $i++) <tr>
                                    <td class="border-2 p-2 text-center">{{ $i+1 }}</td>
                                    <td class="border-2 p-2">{{ $dataLaporanHariIni[$i]->permintaan_bertamu->tamu->nama }}</td>
                                    <td class="border-2 p-2">{{ $dataLaporanHariIni[$i]->permintaan_bertamu->tamu->nik }}</td>
                                    <td class="border-2 p-2 text-center">{{ $dataLaporanHariIni[$i]->check_in }}</td>
                                    </tr>
                                    @endfor
                            </body>
                        </table>
                    </div>
                </div>
                <!--/Graph Card-->
            </div>

            <div class="w-full p-3">
                <!--Table Card-->
                <!-- <div class="bg-white border rounded shadow">
                    <div class="border-b p-3">
                        <h5 class="font-bold uppercase text-gray-600">Table</h5>
                    </div>
                    <div class="p-5">
                        <table class="w-full p-5 text-gray-700">
                            <thead>
                                <tr>
                                    <th class="text-left text-teal-900">Name</th>
                                    <th class="text-left text-teal-900">Side</th>
                                    <th class="text-left text-teal-900">Role</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td>Obi Wan Kenobi</td>
                                    <td>Light</td>
                                    <td>Jedi</td>
                                </tr>
                                <tr>
                                    <td>Greedo</td>
                                    <td>South</td>
                                    <td>Scumbag</td>
                                </tr>
                                <tr>
                                    <td>Darth Vader</td>
                                    <td>Dark</td>
                                    <td>Sith</td>
                                </tr>
                            </tbody>
                        </table>
                        <p class="py-2"><a href="#">See More issues...</a></p>
                    </div>
                </div> -->
                <!--/table Card-->
            </div>
        </div>
        <!--/ Console Content-->
    </div>
</div>
<!--/container-->
@endsection