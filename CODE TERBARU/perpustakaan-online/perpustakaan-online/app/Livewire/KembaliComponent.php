<?php

namespace App\Livewire;

use App\Models\Pengembalian;
use App\Models\Pinjam;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;
use \DateTime; 

class KembaliComponent extends Component
{
    use WithPagination,WithoutUrlPagination;
    protected $paginationTheme = 'bootstrap';
    public $id, $judul, $member,$tglkembali,$lama,$status;

    public function render()
    {
        $layout['title']='Pengembalian Buku';
        $data['pinjam']=Pinjam::where('status','pinjam')->paginate(10);
        $data['pengembalian']=Pengembalian::paginate(10);
        return view('livewire.kembali-component',$data)->layoutData($layout);
    }
    public function pilih($id){
        $pinjam=Pinjam::find($id);
        $this->judul=$pinjam->buku->judul;
        $this->member=$pinjam->user->nama;
        $this->tglkembali=$pinjam->tgl_kembali;
        $this->id=$pinjam->id;

        $kembali=new DateTime($this->tglkembali);
        $today=new DateTime();
        $selisih=$today->diff($kembali);
        //$this->status=$selisih->invert;
        if($selisih->invert==1){
            $this->status=true;
        }
        else{
            $this->status=false;
        }
        $this->lama=$selisih->d;
    }
    public function store()
    {
        if($this->status==true){
            $denda=$this->lama*1000;
        }
        else{
            $denda=0;
        }
        $pinjam=Pinjam::find($this->id);
       Pengembalian::create([
          'pinjam_id'=>$this->id,
          'tgl_kembali'=>date('Y-m-d'),
          'denda'=>$denda
       ]);
       $pinjam->update([
        'status'=>'kembali'
       ]);
       $this->reset();
       session()->flash('success', 'Berhasil Proses Data!');
        return redirect()->route('kembali');
    }
}
