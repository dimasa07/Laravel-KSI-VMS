<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
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
            <!-- <h3 class="font-bold text-2xl">Halaman Login</h3> -->
            @if($pesan = Session::get('sukses'))
            <div class="bg-green-500 text-white w-full text-center rounded py-1 px-4">
                {{ $pesan }}
            </div>
            @endif
            @if($pesan = Session::get('gagal'))
            <div class="bg-red-500 text-white w-full text-center rounded py-1 px-4 ">
                {{ $pesan }}
            </div>
            @endif
        </section>
        <section class="mt-10">
            <form class="flex flex-col" method="POST" action="{{ route('user.login') }}">
                @csrf
                <div class="mb-6 pt-3 rounded bg-gray-100">
                    <label class="block text-gray-700 text-sm font-bold mb-2 ml-3" for="username">Username</label>
                    <input required name="username" type="text" id="username" class="bg-gray-200 rounded w-full text-gray-700 focus:outline-none border-b-4 border-gray-300 focus:border-cyan-600 transition duration-500 px-3 pb-3">
                </div>
                <div class="mb-6 pt-3 rounded bg-gray-100">
                    <label class="block text-gray-700 text-sm font-bold mb-2 ml-3" for="password">Password</label>
                    <input required name="password" type="password" id="password" class="bg-gray-200 rounded w-full text-gray-700 focus:outline-none border-b-4 border-gray-300 focus:border-cyan-600 transition duration-500 px-3 pb-3">
                </div>
                <button class="bg-teal-700 hover:bg-teal-900 text-white font-bold py-2 mt-4 rounded shadow-lg hover:shadow-xl transition duration-200" type="submit">LOGIN</button>
            </form>
            <div class="max-w-lg mx-auto text-center mt-6">
                <p>Belum punya akun? <a href="{{ route('user.form.daftar') }}" class="text-teal-900 font-bold hover:underline">Daftar</a>.</p>
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