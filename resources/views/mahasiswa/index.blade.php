@extends('layout.template')      
@section('konten')
<!-- START DATA -->
<div class="my-3 p-3 bg-body rounded shadow-sm">
  <!-- FORM PENCARIAN -->
  <div class="pb-3">
    <form class="d-flex" action="{{url('mahasiswa')}}" method="get">
        <input class="form-control me-1" type="search" name="search" value="{{ request('search') }}" placeholder="Masukkan kata kunci" aria-label="Search">
        <button class="btn btn-secondary" type="submit">Cari</button>
    </form>
  </div>
  
  <!-- TOMBOL TAMBAH DATA -->
  <div class="pb-3">
    <a href='{{url('mahasiswa/create')}}' class="btn btn-primary">+ Tambah Data</a>
  </div>
  @if ($data->isEmpty())    
      <i><p style="text-align: center; ">Oopss! Mahasiswa tidak ditemukan.</p></i>     
  @else      
  <table class="table table-striped">
      <thead>
          <tr>
              <th class="col-md-1">No</th>
              <th class="col-md-3">NIM</th>
              <th class="col-md-4">Nama</th>
              <th class="col-md-2">Jurusan</th>
              <th class="col-md-2">Aksi</th>
          </tr>
      </thead>
      <tbody>
        <?php $i = $data->firstItem()?>
        @foreach ($data as $item)
        <tr>
          <td>{{ $i }}</td>
          <td>{{$item->nim}}</td>        
          <td>{{$item->nama}}</td>        
          <td>{{$item->jurusan}}</td>
          <td>
              <a href="{{url('mahasiswa/'.$item->nim.'/edit')}}" class="btn btn-warning">Edit</a> |        
              <form action="{{ route('mahasiswa.destroy', $item->nim) }}" method="post" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
              </form>
            </td>        
        </tr>
        <?php $i++?>
        @endforeach
      </tbody>
  </table>
  {{$data->withQueryString()->links()}}
  @endif
</div>
<!-- AKHIR DATA -->    
@endsection 
        
   