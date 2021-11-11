<html>
<style>
    table {
        border-collapse: collapse;
        width: 100%;
        text-align: center;
    }
    h1 {
        text-align: center;
    }
</style>
<div class="col-lg-12">
    <center>
    <h1>Kartu Hasil Studi (KHS)</h1>
    </center>
        <b>Nim : </b> {{$mahasiswa->Nim}}
        <br><br>
        <b>Nama : </b> {{$mahasiswa->Nama}}
        <br><br>
        <b>Kelas : </b> {{$mahasiswa->kelas->nama_kelas}}
        <br>
</div>
<table class="table table-bordered" border="1">
    <tr>
        <th>Mata Kuliah</th>
        <th>SKS</th>
        <th>Semester</th>
        <th>Nilai</th>
    </tr>
    @foreach ($nilai as $item)
        <tr>
            <td> {{ $item->nama_matkul }} </td>
            <td> {{ $item->sks }} </td>
            <td> {{ $item->semester }} </td>
            <td> {{ $item->nilai }} </td>
        </tr>
     @endforeach
</table>
</html>