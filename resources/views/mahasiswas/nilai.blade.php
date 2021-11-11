@extends('mahasiswas.layout')

@section('content')
<div class="col-lg-12 margin-tb">
    <div class="pull-left mt-2">
        <h2>JURUSAN TEKNOLOGI INFORMASI-POLITEKNIK NEGERI MALANG</h2>
    </div>
    <div class="col-lg-12">
        <h1>Kartu Hasil Studi (KHS)</h1>
    </div>
            <br><br>
            <b>Nim : </b> {{$mahasiswa->Nim}}
            <br><br>
            <b>Nama : </b> {{$mahasiswa->Nama}}
            <br><br>
            <b>Kelas : </b> {{$mahasiswa->Kelas->nama_kelas}}
</div>
    <table class="table table-bordered" border="1">
        <tr>
            <th>Mata Kuliah</th>
            <th>SKS</th>
            <th>Semester</th>
            <th>Nilai</th>
        </tr>
        @foreach ($nilai as $isi)
        <tr>
            <td> {{ $isi->nama_matkul }} </td>
            <td> {{ $isi->sks }} </td>
            <td> {{ $isi->semester }} </td>
            <td> {{ $isi->nilai }} </td>
        </tr>
        @endforeach
    </table>
    <a class="btn btn-danger" href="{{route('mahasiswas.index')}}">Kembali</a>
    </div>
    </div>
</div>
@endsection