<?php

namespace App\Livewire;
use App\Models\Kategori;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;

class KategoriComponent extends Component
{
    use WithPagination,WithoutUrlPagination;
    protected $paginationTheme = 'bootstrap';
    public $nama, $id,$deskripsi,$cari;

    public function render()
    {
        if($this->cari!=""){
            $data['kategori']=Kategori::where('nama','like','%'. $this->cari .'%')->paginate(10);
        }else{
            $data['kategori']=Kategori::paginate(10);
        }
        $layout['title']='Kelola Kategori Buku';
        return view('livewire.kategori-component',$data)->layoutData($layout);
    }
    public function store(){
        $this->validate([
            'nama'=>'required',
            'deskripsi'=>'required'
        ],[
           'nama.required'=>'Nama tidak boleh kosong',
           'deskripsi.required'=>'Deskripsi tidak boleh kosong'
        ]);
        Kategori::create([
           'nama'=>$this->nama,
           'deskripsi'=>$this->deskripsi
        ]);
        session()->flash('success', 'Berhasil simpan!');
        return redirect()->route('kategori');
    }
    public function edit($id){
        $kategori=Kategori::find($id);
        $this->id=$kategori->id;
        $this->nama=$kategori->nama;
        $this->deskripsi=$kategori->deskripsi;
    }
    public function update()
{
    // Pastikan menggunakan properti $this->id, bukan $id
    $kategori = Kategori::find($this->id);

    if ($kategori) {
        $kategori->update([
            'nama' => $this->nama,
            'deskripsi' => $this->deskripsi,
        ]);

        // Reset form setelah update
        $this->reset(['id', 'nama', 'deskripsi']);
        session()->flash('success', 'Berhasil ubah!');
    } else {
        session()->flash('error', 'Kategori tidak ditemukan.');
    }

    // Redirect ke halaman yang sama
    return redirect()->route('kategori');
}

    public function confirm($id){
        $this->id=$id;
    }
    public function destroy()
{
    // Gunakan $this->id untuk mendapatkan ID yang disimpan sebelumnya
    $kategori = Kategori::find($this->id);

    if ($kategori) {
        $kategori->delete(); // Memanggil metode delete pada model
        session()->flash('success', 'Kategori berhasil dihapus!');
    } else {
        session()->flash('error', 'Kategori tidak ditemukan.');
    }

    // Reset properti setelah operasi selesai
    $this->reset(['id', 'nama', 'deskripsi']);

    // Redirect ke halaman kategori
    return redirect()->route('kategori');
}

}
