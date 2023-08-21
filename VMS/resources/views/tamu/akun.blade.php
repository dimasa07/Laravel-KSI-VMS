@extends('layouts.layout_tamu')

@section('title','Tamu - Akun')

@section('content')
<!--Container-->
<div class="container w-full mx-auto pt-20">
    <div class="w-full px-4 md:px-0 md:mt-8 mb-16 text-gray-800 leading-normal">
        <div class="w-full p-3">
            <!--Table Card-->
            <div class="bg-white border rounded shadow">
                <div class="border-b px-3 py-6">
                    <h5 class="ml-5 text-3xl font-bold uppercase text-gray-600">Akun</h5>
                </div>
            </div>
        </div>
        <div class="w-full p-3">
            <!--Table Card-->
            <div class="bg-white border rounded shadow">
                <div class="p-5" x-data="{ showConfirmHapus:false, showFormEdit : false, akun:{{$akun}}, showAlert:true }">
                    @if($pesan = Session::get('gagal'))
                    <div x-show="showAlert" class="bg-red-500 text-white w-full text-center rounded mb-6 p-1">
                        {{ $pesan }}
                    </div>
                    @endif
                    @if($pesan = Session::get('sukses'))
                    <div x-show="showAlert" class="bg-green-500 text-white w-full text-center rounded mb-6 p-1">
                        {{ $pesan }}
                    </div>
                    @endif
                    <form method="POST" @submit.prevent="submit()" x-data="formData()">
                        <div class="relative pb-11 px-6">
                            <table class="w-full p-5 text-gray-700" x-show="!showFormEdit">
                                <tbody>
                                    <tr>
                                        <td class="w-40">Role</td>
                                        <td class="w-6">:</td>
                                        <td>{{ $akun->role }}</td>
                                    </tr>
                                    <tr>
                                        <td class="w-40">Username</td>
                                        <td class="w-6">:</td>
                                        <td>{{ $akun->username }}</td>
                                    </tr>
                                    {{-- <tr>
                                        <td class="w-40">Password</td>
                                        <td class="w-6">:</td>
                                        <td>{{ $akun->password }}</td>
                                    </tr> --}}
                                </tbody>
                            </table>
                            <table style="display: none;" class="w-full p-5 text-gray-700" x-show="showFormEdit">
                                <tbody>
                                    <tr>
                                        <td class="w-40">Role</td>
                                        <td class="w-6">:</td>
                                        <td><input disabled x-model="formData.role" class="px-1 border border-gray-600" type="text" name="role" :value="akun.role"></td>
                                    </tr>
                                    <tr>
                                        <td class="w-40">Username</td>
                                        <td class="w-6">:</td>
                                        <td><input required x-model="formData.username" class="px-1 border border-gray-600" type="text" name="username" :value="akun.username"></td>

                                    </tr>
                                    {{-- <tr>
                                        <td class="w-40">Password</td>
                                        <td class="w-6">:</td>
                                        <td><input required x-model="formData.password" class="px-1 border border-gray-600" type="text" name="password" :value="akun.password"></td>

                                    </tr> --}}
                                </tbody>
                            </table>
                            <div class="inline-flex absolute right-0 bottom-0">
                                <button type="button" x-show="!showFormEdit" @click="showFormEdit= !showFormEdit; akun={{$akun}}; showAlert=false; showConfirmHapus=false" class=" bg-blue-600 hover:bg-blue-800 text-white py-1 px-2 rounded mx-2">Edit Akun</button>
                                <button type="button" href="#" x-show="!showFormEdit && !showConfirmHapus" @click="showConfirmHapus=true" class=" bg-red-600 hover:bg-red-800 text-white py-1 px-2 rounded mx-2">Hapus Akun</button>
                                <a x-bind:href="window.location.origin+'/tamu/akun/delete'">
                                    <button style="display: none;" type="button" x-show="showConfirmHapus && !showFormEdit" class=" bg-red-600 hover:bg-red-800 text-white py-1 px-2 rounded mx-2">Konfirmasi Hapus</button></a>

                                <button style="display: none;" type="submit" @click="formData.id=akun.id;" x-show="showFormEdit" class=" bg-green-600 hover:bg-green-800 text-white py-1 px-2 rounded mx-2">Simpan Perubahan</button>
                                <button style="display: none;" x-show="showFormEdit||showConfirmHapus" type="button" @click="showFormEdit=false; showConfirmHapus=false" class=" bg-gray-600 hover:bg-gray-800 text-white py-1 px-2 rounded mx-2">Batal</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
            <!--/table Card-->
        </div>
    </div>
</div>
<script>
    function submit() {
        var formData = this.formData;
        $.ajax({
            type: 'POST',
            url: window.location.origin + "/tamu/akun/update",
            data: {
                'id': formData.id,
                'role': formData.role,
                'username': formData.username == null ? '{{$akun->username}}' : formData.username,
                'password': formData.password
            },
            success: function(success) {
                // console.log("sukses");
                location.reload();
            },
            error: function(error) {
                console.log(error);
                // document.body.innerHTML = success;
                // location.reload();
            }
        });
    }

    window.formData = function() {
        return {
            id: 0,
            role: '{{$akun->role}}',
            username: '{{$akun->username}}',
            password: '{{$akun->password}}'

        }
    }
</script>
@endsection