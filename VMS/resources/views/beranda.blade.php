@extends('layouts.layout_main')

@section('title','Beranda')

@section('content')
<div class="pt-24">
    <div class="container px-3 mx-auto flex flex-wrap flex-col md:flex-row items-center">
        <!--Left Col-->
        <div class="flex flex-col w-full md:w-2/5 justify-center items-start text-center md:text-left">
            <h1 class="my-4 text-5xl font-bold leading-tight">
                Selamat datang
            </h1>
            <p class="leading-normal text-2xl mb-8">
                Silahkan mendaftar jika belum mempunyai akun.
            </p>
            <a href="{{ route('user.daftar') }}">
                <button class="mx-auto lg:mx-0 hover: bg-teal-200 hover:bg-teal-400 text-teal-900 font-bold rounded-full my-6 py-2 px-8 shadow-lg focus:outline-none focus:shadow-outline transform transition hover:scale-105 duration-300 ease-in-out hover:text-teal-900">
                    Daftar
                </button>
            </a>
        </div>
        <!--Right Col-->
        <div class="w-full md:w-3/5 py-6 text-center">
            <img class="w-full md:w-4/5 z-50" src="" />
        </div>
    </div>
</div>

@endsection('content')