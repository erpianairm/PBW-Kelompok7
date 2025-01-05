<?php

namespace App\Livewire;
use App\Models\Buku;
use App\Models\User;
use App\Models\Pinjam;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;

class PinjamComponent extends Component
{
    use WithPagination,WithoutUrlPagination;
    protected $paginationTheme = 'bootstrap';
    public $user, $buku,$tgl_pinjam,$tgl_kembali,$id;
    public function render()
    {
       $data['member']=User::where('jenis','member')->get();
        $data['book']=Buku::all();
        $data['pinjam']=Pinjam::paginate(10);
        $layout['title']='Pinjam Buku';
        return view('livewire.pinjam-component',$data)->layoutData($layout); 
    }
    public function store(){
        $this->validate([
           'buku'=>'required',
           'user'=>'required'
        ],[
            'buku.required'=>'Buku harus Dipilih!',
            'user.required'=>'Member harus Dipilih!',
        ]);
        $this->tgl_pinjam= date('Y-m-d');
        $this->tgl_kembali=date('Y-m-d',strtotime($this->tgl_pinjam.'+7days'));
        Pinjam::create([
           'user_id' => $this->user,
            'buku_id' => $this->buku,
            'tgl_pinjam' => $this->tgl_pinjam,
            'tgl_kembali' => $this->tgl_kembali,
            'status'=>'pinjam'
        ]);
        $this->reset();
        session()->flash('success', 'Berhasil proses data!');
        return redirect()->route('pinjam');
    }
    public function edit($id){
        $pinjam=Pinjam::find($id);
        $this->id=$pinjam->id;
        $this->user=$pinjam->user_id;
        $this->buku=$pinjam->buku_id;
        $this->tgl_pinjam=$pinjam->tgl_pinjam;
        $this->tgl_kembali=$pinjam->tgl_kembali;
    }
    public function update()
    {
        $pinjam=Pinjam::find($this->id);
        $this->tgl_pinjam= date('Y-m-d');
        $this->tgl_kembali=date('Y-m-d',strtotime($this->tgl_pinjam.'+7days'));
        $pinjam->update([
            'user_id' => $this->user,
            'buku_id' => $this->buku,
            'tgl_pinjam' => $this->tgl_pinjam,
            'tgl_kembali' => $this->tgl_kembali,
            'status'=>'pinjam'
        ]);
        $this->reset();
        session()->flash('success', 'Berhasil ubah data!');
        return redirect()->route('pinjam');
    }
    public function confirm($id){
        $this->id=$id;
    }
    public function destroy(){
        $pinjam=Pinjam::find($this->id);
        $pinjam->delete();
        $this->reset();
        session()->flash('success', 'Berhasil hapus data!');
        return redirect()->route('pinjam');
    }
}
