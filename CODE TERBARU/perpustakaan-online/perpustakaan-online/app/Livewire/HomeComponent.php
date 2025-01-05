<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Buku;
use App\Models\Pinjam;
use App\Models\Pengembalian;

class HomeComponent extends Component
{
    public function render()
    {
        $x['title']="Home perpustakaan";
        $data['member']=User::where('jenis','member')->count();
        $data['buku']=Buku::count();
        $data['pinjam']=Pinjam::where('status','pinjam')->count();
        $data['kembali']=Pengembalian::count();
        return view('livewire.home-component',$data)->layoutData($x);
    }
}
