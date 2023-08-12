@extends('layouts.layout_main')

@section('title','Struktur Organisasi')

@section('content')
<div class="pt-24">
    <div class="container px-3 mx-auto flex flex-wrap flex-col md:flex-row items-center">
        <!--Left Col-->
        <div class="flex flex-col w-full justify-center items-start text-center md:text-left">
            <h1 class="my-4 text-4xl font-bold leading-tight">
                Struktur Organisasi
            </h1>

            <!--Right Col-->
            <div class="w-full py-6 text-center px-20">
                <img class="w-full z-50" src="{{ asset('img/struktur.JPG') }}" />
            </div>
        </div>
    </div>
</div>
@endsection