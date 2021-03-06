<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Kelas;
use PDF;

class MahasiswaController extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //fungsi eloquent menampilkan data menggunakan pagination
        $mahasiswas = Mahasiswa::with('kelas')->get();
        $paginate = Mahasiswa::orderBy('nim', 'asc')->paginate(3);
        //$mahasiswas = DB::table('mahasiswa')->paginate(5);
        return view('mahasiswas.index', ['mahasiswa' => $mahasiswas, 'paginate'=>$paginate]);
    }
    public function create()
    {
        $kelas = Kelas::all();
        return view('mahasiswas.create', ['kelas'=>$kelas]);
    }
    public function store(Request $request)
    {

    //melakukan validasi data
        $request->validate([
            'Nim' => 'required',
            'Nama' => 'required',
            'Kelas' => 'required',
            'Jurusan' => 'required',
            'No_Handphone' => 'required',
            'Email' => 'required',
            'Tanggal_Lahir' => 'required'
        ]);

        //fungsi eloquent untuk menambah data
        //Mahasiswa::create($request->all());
        $mahasiswas = new Mahasiswa;
        $mahasiswas->nim = $request->get('Nim');
        $mahasiswas->nama = $request->get('Nama');
        $mahasiswas->kelas_id = $request->get('Kelas');
        $mahasiswas->jurusan = $request->get('Jurusan');
        $mahasiswas->no_handphone = $request->get('No_Handphone');
        $mahasiswas->email = $request->get('Email');
        $mahasiswas->tanggal_lahir = $request->get('Tanggal_Lahir');
        if ($request->file('foto')){
            $file = $request->file('foto')->store('images', 'public');
            $mahasiswas->foto = $file;
        }
        $mahasiswas->save();

        //jika data berhasil ditambahkan, akan kembali ke halaman utama
        return redirect()->route('mahasiswas.index')
            ->with('success', 'Mahasiswa Berhasil Ditambahkan');
    }

    public function show($Nim)
    {
        //menampilkan detail data dengan menemukan/berdasarkan Nim Mahasiswa
        $Mahasiswa = Mahasiswa::with('kelas')->where('nim', $Nim)->first();
        return view('mahasiswas.detail', ['Mahasiswa'=>$Mahasiswa]);
    }

    public function edit($Nim)
    {

 //menampilkan detail data dengan menemukan berdasarkan Nim Mahasiswa untuk diedit
        $Mahasiswa = Mahasiswa::with('kelas')->where('nim', $Nim)->first();
        $kelas = Kelas::all();
        return view('mahasiswas.edit', compact('Mahasiswa', 'kelas'));
    }

    public function update(Request $request, $Nim)
    {

 //melakukan validasi data
        $request->validate([
            'Nim' => 'required',
            'Nama' => 'required',
            'Kelas' => 'required',
            'Jurusan' => 'required',
            'No_Handphone' => 'required',
            'Email' => 'required',
            'Tanggal_Lahir' => 'required',
        ]);

        $mahasiswas = Mahasiswa::with('kelas')->where('nim', $Nim)->first();
        $mahasiswas->nim = $request->get('Nim');
        $mahasiswas->nama = $request->get('Nama');
        $mahasiswas->jurusan = $request->get('Jurusan');
        $mahasiswas->no_handphone = $request->get('No_Handphone');
        $mahasiswas->email = $request->get('Email');
        $mahasiswas->tanggal_lahir = $request->get('Tanggal_Lahir');
        if ($request->file('foto')){
            $file = $request->file('foto')->store('images', 'public');
            $mahasiswas->foto = $file;
        }
        $mahasiswas->save();

        $kelas = new Kelas;
        $kelas->id = $request->get('Kelas');

    //fungsi eloquent untuk mengupdate data inputan kita
        //Mahasiswa::find($Nim)->update($request->all());
        $mahasiswas->kelas()->associate($kelas);
        $mahasiswas->save();

    //jika data berhasil diupdate, akan kembali ke halaman utama
        return redirect()->route('mahasiswas.index')
            ->with('success', 'Mahasiswa Berhasil Diupdate');
    }
    public function destroy( $Nim)
     {
 //fungsi eloquent untuk menghapus data
         Mahasiswa::find($Nim)->delete();
        return redirect()->route('mahasiswas.index')
            -> with('success', 'Mahasiswa Berhasil Dihapus');
     }
    
    public function search(Request $request)
    {
        $keyword = $request->search;
        $mahasiswas = Mahasiswa::where('Nama', 'like', "%" .$keyword . "%")->paginate(5);
        return view('mahasiswas.index', compact('mahasiswas'));
    }

    public function nilai($Nim)
    {
        $mahasiswa = Mahasiswa::with('kelas')->find($Nim);

        $nilai = DB::table('mahasiswa_matakuliah')
            ->join('matakuliah', 'matakuliah.id', '=', 'mahasiswa_matakuliah.mk_id')
            ->join('mahasiswa', 'mahasiswa.Nim', '=', 'mahasiswa_matakuliah.mhs_id')
            ->select('mahasiswa_matakuliah.*', 'matakuliah.*')
            ->where('mhs_id', $Nim)
            ->get();
        return view('mahasiswas.nilai', compact('mahasiswa', 'nilai'));
    }

    public function cetak_pdf($Nim)
    {
        $mahasiswa = Mahasiswa::with('kelas')->find($Nim);
        $nilai = DB::table('mahasiswa_matakuliah')
            ->join('matakuliah', 'matakuliah.id', '=', 'mahasiswa_matakuliah.mk_id')
            ->join('mahasiswa', 'mahasiswa.Nim', '=', 'mahasiswa_matakuliah.mhs_id')
            ->select('mahasiswa_matakuliah.*', 'matakuliah.*')
            ->where('mhs_id', $Nim)
            ->get();

        $pdf = PDF::loadview('mahasiswas.cetak_pdf', compact('mahasiswa','nilai'));
        return $pdf->stream();
    }
}