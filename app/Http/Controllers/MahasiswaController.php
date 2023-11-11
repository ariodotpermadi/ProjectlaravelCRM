<?php

namespace App\Http\Controllers;

use App\Models\mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $jumlahbaris = 4;
        if (strlen($search)) {
            # code...
            $data = mahasiswa::where('nim', 'like', '%' . $search . '%')
                ->orWhere('nama', 'like', '%' . $search . '%')
                ->orWhere('jurusan', 'like', '%' . $search . '%')
                ->paginate($jumlahbaris);
        } else {
            # code...
            $data = mahasiswa::orderBy('nim', 'desc')->paginate($jumlahbaris);
        }
        return view('mahasiswa.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('mahasiswa.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Session::flash('nim', $request->nim);
        Session::flash('nama', $request->nama);
        Session::flash('jurusan', $request->jurusan);
        $request->validate([
            'nim' => 'required|numeric|unique:mahasiswa,nim',
            'nama' => 'required',
            'jurusan' => 'required',
        ], [
            'nim.required' => 'NIM wajib diisi.',
            'nim.unique' => 'NIM sudah ada.',
            'nim.numeric' => 'NIM Harus berupa angka.',
            'nama.required' => 'Nama wajib diisi.',
            'jurusan' => 'Jurusan wajib diisi.'
        ]);


        $data = [
            'nim' => $request->nim,
            'nama' => $request->nama,
            'jurusan' => $request->jurusan
        ];

        mahasiswa::create($data);

        return redirect()->route('mahasiswa.index')->with('success', 'Berhasil menambahkan data.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // $data = mahasiswa::where('nim', $id)->first();
        $data = mahasiswa::where('nim', $id)->first();
        return view('mahasiswa.edit')->with('data', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama' => 'required',
            'jurusan' => 'required',
        ], [
            'nama.required' => 'Nama wajib diisi.',
            'jurusan' => 'Jurusan wajib diisi.'
        ]);


        $data = [
            'nama' => $request->nama,
            'jurusan' => $request->jurusan
        ];

        mahasiswa::where('nim', $id)->update($data);

        return redirect()->route('mahasiswa.index')->with('success', 'Berhasil melakukan update data.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        mahasiswa::where('nim', $id)->delete();

        return redirect()->route('mahasiswa.index')->with('success', 'Data berhasil dihapus.');
    }
}
