<?php

namespace App\Livewire;
use App\Models\Kategori;
use App\Models\Buku;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;

class BukuComponent extends Component
{
    use WithPagination,WithoutUrlPagination;
    protected $paginationTheme = 'bootstrap';
    public $kategori, $judul,$penulis,$penerbit, $isbn,$tahun,$jumlah,$cari,$id;
    public function render()
    {
        if($this->cari!=""){
            $data['buku']=Buku::where('judul','like','%'. $this->cari .'%')->paginate(10);
        }else{
            $data['buku']=Buku::paginate(10);
        }
       
        $data['category']=Kategori::all();
        $layout['title']='Kelola Buku';
        return view('livewire.buku-component',$data)->layoutData($layout);
    }
    public function store(){
        $this->validate([
            'judul'=>'required',
           'kategori'=>'required',
           'penulis'=>'required',
           'penerbit'=>'required',
           'tahun'=>'required',
           'isbn'=>'required',
           'jumlah'=>'required'
        ],[
            'judul.required'=>'Judul tidak boleh kosong',
           'kategori.required'=>'Kategori tidak boleh kosong',
           'penulis.required'=>'penulis tidak boleh kosong',
           'penerbit.required'=>'penerbit tidak boleh kosong',
           'tahun.required'=>'tahun tidak boleh kosong',
           'isbn.required'=>'isbn tidak boleh kosong',
            'jumlah.required'=>'jumlah tidak boleh kosong'
        ]);
        Buku::create([
            'judul'=>$this->judul,
            'kategori_id'=>$this->kategori,
            'penulis' => $this->penulis,
            'penerbit' => $this->penerbit,
            'tahun' => $this->tahun,
            'isbn' => $this->isbn,
            'jumlah' => $this->jumlah
        ]);
        $this->reset();
        session()->flash('success', 'Berhasil tambah!');
        return redirect()->route('buku');
    }
     public function edit($id){
        $buku=Buku::find($id);
        $this->id=$buku->id;
        $this->judul=$buku->judul;
        $this->kategori=$buku->kategori->id;
        $this->penulis=$buku->penulis;
        $this->penerbit=$buku->penerbit;
        $this->tahun=$buku->tahun;
        $this->isbn=$buku->isbn;
        $this->jumlah=$buku->jumlah;
     }
     public function update(){
        $buku=Buku::find($this->id);
        $buku->update([
            'judul'=>$this->judul,
            'kategori_id'=>$this->kategori,
            'penulis' => $this->penulis,
            'penerbit' => $this->penerbit,
            'tahun' => $this->tahun,
            'isbn' => $this->isbn,
            'jumlah' => $this->jumlah
        ]);
        $this->reset();
        session()->flash('success', 'Berhasil ubah!');
        return redirect()->route('buku');
     }
     public function confirm($id)
     {
        $this->id=$id;
     }
     public function destroy(){
        $buku=Buku::find($this->id);
        $buku->delete();
        $this->reset();
        session()->flash('success', 'Berhasil Hapus!');
        return redirect()->route('buku');
     }
}
