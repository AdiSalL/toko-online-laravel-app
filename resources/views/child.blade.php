@extends("layouts.app")

@section("title")
    Aplikasi Toko Online
@endsection

@section("content")
    @component("alert", ["type" => "success"])
        Alert Latihan Berhasil
    @endcomponent
    Konten dari child view
@endsection



