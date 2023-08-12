@extends('layouts.layout_main')

@section('title','Visi dan Misi')

@section('content')
<div class="pt-24">
    <div class="container px-3 mx-auto flex flex-wrap flex-col md:flex-row items-center">
        <!--Left Col-->
        <div class="flex flex-col w-full justify-center items-start text-center md:text-left pr-32">
            <h1 class="my-4 text-4xl font-bold leading-tight">
                Visi dan Misi
            </h1>
            <span class="font-bold leading-normal text-2xl ml-20 ">
                VISI KABUPATEN BANDUNG :
            </span>
            <ul class="list-disc ml-28">
                <li>"Terwujudnya Masyarakat Kabupaten Bandung Yang Bangkit, Edukatif, Dinamis, Agamis dan Sejahtera"</li>
            </ul>
            <span class="font-bold leading-normal text-2xl mt-10 ml-20">
                MISI KABUPATEN BANDUNG :
            </span>
            <ul type="" class="list-disc ml-28">
                <li>Misi 1 : Membangkitkan daya saing daerah.</li>
                <li>Misi 2 : Menyediakan layanan pendidikan dan kesehatan yang berkualitas dan merata.</li>
                <li>Misi 3 : Mengoptimalkan pembangunan daerah berbasis partisipasi masyarakat yang menjunjung tinggi kreatiftas dalam bingkai kearifan lokal dan berwawasan lingkungan.</li>
                <li>Misi 4 : Mengoptimalkan tata kelola pemerintahan melalui birokrasi yang profesional, dan tata kehidupan masyarakat yang berlandaskan nilai-nilai keagamaan.</li>
                <li>Misi 5 : Meningkatkan kesejahteraan masyarakat dengan prinsip keadilan dan keberpihakan pad kelompok masyarakat rendah.</li>
            </ul>

            <div class="ml-20  mt-10 leading-norma">
                <span class="font-boldl text-xl">
                    TUGAS POKOK DAN FUNGSI DINAS KOMUNIKASI, INFORMATIKA DAN STATISTIK KABUPATEN BANDUNG
                </span>
                <p>Rincian Tugas Pokok, Fungsi dan Tata Kerja Dinas Komunikasi, Informatika dan Statistik Kabupaten Bandung adalah sebagai berikut : </p>
                <ol type="1" class="list-decimal ml-10">
                    <li>Kepala Dinas</li>
                    <li class="mt-4">Sekretaris :
                        <ul class="list-disc ml-4">
                            <li>Subagian Penyusunan Program</li>
                            <li>Subagian Umum dan Kepegawaian</li>
                            <li>Subagian Keuangan</li>
                        </ul>
                    </li>
                    <li class="mt-4">Bidang Penyelenggaraan Informasi dan Komunikasi Publik :
                        <ol type="a" class="list-disc ml-4">
                            <li>Penyelenggaraan perumusan kebijakan teknis operasional bidang Penyelenggaraan Informasi dan Komunikasi Publik;</li>
                            <li>Penyelenggaraan rencana kerja bidang Penyelenggaraan Informasi dan Komunikasi Publik, meliputi penyelenggaraan informasi publik, penyelenggaraan komunikasi publik dan pengelolaan informasi dan dokumentasi;</li>
                            <li>Penyelenggaraan koordinasi, integrasi dan sinkronisasi sesuai dengan lingkup tugasnya;
                            <li>Penyelenggaraan monitoring, evaluasi dan pelaporan capaian kinerja bidang Penyelenggaraan Informasi dan Komunikasi Publik, meliputi penyelenggaraan informasi publik, penyelenggaraan komunikasi publik dan pengelolaan informasi dan dokumentasi;</li>
                        </ol>
                    </li>
                    <li class="mt-4">Bidang Keamanan Informasi dan Persandian
                        <ol type="a" class="list-disc ml-4">
                            <li>Penyelenggaraan perumusan kebijakan teknis operasional Bidang Keamanan Informasi dan Persandian;</li>
                            <li>Penyelenggaraan rencana kerja Bidang Keamanan Informasi dan Persandian;</li>
                            <li>Penyelenggaraan koordinasi, integrasi dan sinkronisasi sesuai dengan lingkup tugasnya;</li>
                            <li>Penyelenggaraan monitoring, evaluasi dan pelaporan capaian kinerja Keamanan Informasi dan Persandian.</li>
                        </ol>
                    </li>
                    <li class="mt-4">Bidang Teknologi Informasi dan Komunikasi
                        <ol type="a" class="list-disc ml-4">
                            <li>Penyelenggaraan perumusan kebijakan teknis operasional bidang Teknologi Informasi dan Komunikasi, meliputi tata kelola infrastruktur TIK, layanan infrastruktur dasar TIK, layanan jaringan komunikasi data;</li>
                            <li>Penyelenggaraan rencana kerja bidang Teknologi Informasi dan Komunikasi, meliputi tata kelola infrastruktur TIK, layanan infrastruktur dasar TIK, layanan jaringan komunikasi data;</li>
                            <li>Penyelenggaraan koordinasi, integrasi dan sinkronisasi sesuai dengan lingkup tugasnya;</li>
                            <li>Penyelenggaraan monitoring, evaluasi dan pelaporan capaian kinerja bidang Teknologi Informasi dan Komunikasi.</li>
                        </ol>
                    </li>
                    <li class="mt-4">Bidang Aplikasi Informatika
                        <ol type="a" class="list-disc ml-4">
                            <li>Penyelenggaraan perumusan kebijakan teknis operasional bidang Aplikasi Informatika, meliputi pengembangan aplikasi, integrasi dan interoperabilitas aplikasi, tata kelola aplikasi informatika;</li>
                            <li>Penyelenggaraan rencana kerja bidang Aplikasi Informatika, meliputi pengembangan aplikasi, integrasi dan interoperabilitas aplikasi, tata kelola aplikasi informatika;</li>
                            <li>Penyelenggaraan koordinasi, integrasi dan sinkronisasi sesuai dengan lingkup tugasnya;</li>
                            <li>Penyelenggaraan monitoring, evaluasi dan pelaporan capaian kinerja bidang Aplikasi Informatika, meliputi pengembangan aplikasi, integrasi dan interoperabilitas aplikasi, tata kelola aplikasi informatika.</li>
                        </ol>
                    </li>
                    <li class="my-4">Bidang Statistik 
                        <ol type="a" class="list-disc ml-4">
                            <li>Penyelenggaraan perumusan kebijakan teknis operasional bidang Statistik, meliputi pengumpulan data statistik, pengolahan analisa data statistik, penyajian dan evaluasi pelaporan data statistik;</li>
                            <li>Penyelenggaraan rencana kerja bidang Statistik meliputi pengumpulan data statistik, pengolahan analisa data statistik, penyajian dan evaluasi pelaporan data statistik;</li>
                            <li>Penyelenggaraan koordinasi, integrasi dan sinkronisasi sesuai dengan lingkup tugasnya;</li>
                            <li>Penyelenggaraan monitoring, evaluasi dan pelaporan capaian kinerja bidang Statistik, meliputi pengumpulan data statistik, pengolahan analisa data statistik, penyajian dan evaluasi pelaporan data statistik.</li>
                        </ol>
                    </li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection