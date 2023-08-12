<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Daftar</title>
    <meta name="author" content="David Grzyb">
    <meta name="description" content="">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
    <style>
        .body-green {
            background: #036163;
        }
    </style>
</head>

<body class="body-green min-h-screen pt-12 md:pt-10 pb-6 px-2 md:px-0" style="font-family:'Lato',sans-serif;">
    <header class="max-w-lg mx-auto">
        <a href="#">
            <h1 class="text-2xl lg:text-4xl font-bold text-white text-center">DISKOMINFO</h1>
        </a>
    </header>

    <main class="bg-gray-100 max-w-lg mx-auto p-8 md:p-12 my-10 rounded-lg shadow-2xl">
        <section>
            <h1 class="text-teal-900 mb-8 text-3xl text-center font-bold">Pendaftaran</h1>
            @if($pesan = Session::get('eror'))
            <div class="bg-red-500 text-white w-full text-center rounded mb-6 p-1">
                {{ $pesan }}
            </div>
            @endif
            <form autocomplete="off" method="POST" action="{{ route('user.daftar') }}">
                <!-- <input type="text" class="block border border-gray-400 w-full p-3 rounded mb-4" name="nik" placeholder="NIK" /> -->
                <!-- <input required type="text" class="block border border-gray-400 w-full p-3 rounded mb-4" name="nama" placeholder="Nama Lengkap" /> -->
                <!-- <input type="number" class="block border border-gray-400 w-full p-3 rounded mb-4" name="no_telepon" placeholder="No. Telepon" />
                <input type="email" class="block border border-gray-400 w-full p-3 rounded mb-4" name="email" placeholder="Email" />
                <input type="text" class="block border border-gray-400 w-full p-3 rounded mb-4" name="alamat" placeholder="Alamat" /> -->
                <input type="hidden" name="role" value="TAMU">
                <input required type="text" class="block border border-gray-400 w-full p-3 rounded mb-4" name="username" placeholder="Username" />
                <input required type="password" class="block border border-gray-400 w-full p-3 rounded mb-4" name="password" placeholder="Password" />
                <input required type="password" class="block border border-gray-400 w-full p-3 rounded mb-4" name="re_password" placeholder="Re-password" />
                <button type="submit" class="w-full text-center py-3 rounded bg-teal-700 font-bold text-white hover:bg-teal-900 focus:outline-none my-1">Daftar</button>
            </form>
            <div class="text-gray-700 mt-6 text-center">
                Sudah punya akun?
                <a class="no-underline font-bold text-teal-900 hover:underline" href="{{ route('user.login') }}">
                    Login
                </a>.
            </div>
            <div class="text-gray-700 mt-6 text-center">
                <a class="no-underline font-bold text-teal-900 hover:underline" href="{{ route('beranda') }}">
                    Beranda
                </a>
            </div>
        </section>
    </main>



    <!-- <footer class="max-w-lg mx-auto flex justify-center text-white">
        <a href="#" class="hover:underline">Contact</a>
        <span class="mx-3">•</span>
        <a href="#" class="hover:underline">Privacy</a>
    </footer> -->
</body>

</html>