@extends('layouts.layout_tamu')

@section('title','Tamu - Dasbor')

@section('content')
<!--Container-->
<div class="container w-full mx-auto pt-20">
    <div class="w-full px-4 md:px-0 md:mt-8 mb-16 text-gray-800 leading-normal">
        <div class="w-full p-3">
            <!--Table Card-->
            <div class="bg-white border rounded shadow">
                <div class="border-b px-3 py-6">
                    <h5 class="ml-5 text-3xl font-bold uppercase text-gray-600">Selamat Datang !</h5>
                </div>
            </div>
        </div>

        <div class="w-full p-3">
            <!--Table Card-->
            <div class="bg-white border rounded shadow">

                @if(session()->get('id')==0)
                <div class="p-5">
                    <h3 class="text-1xl">Data identitas anda belum ada, silahkan edit <a class="text-blue-800 underline" href="{{ route('tamu.profil') }}">profil</a> untuk menambahkan identitas.</h3>
                </div>
                @else
                <div class="p-5">
                    <h3 class="text-1xl">Ada rencana untuk bertamu ? <a class="text-blue-800 underline" href="{{ route('tamu.permintaan.buat') }}">Buat permintaan</a></h3>
                </div>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection