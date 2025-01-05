<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class UserComponent extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $nama, $email, $password, $id;

    public function render()
    {
        $layout['title'] = "Kelola User";
        $data['user'] = User::paginate(10);

        return view('livewire.user-component', $data)->layoutData($layout);
    }

    public function store()
    {
        $this->validate([
            'nama' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ], [
            'nama.required' => 'Nama tidak boleh kosong!',
            'email.required' => 'Email tidak boleh kosong!',
            'email.email' => 'Format email salah!',
            'password.required' => 'Password tidak boleh kosong!',
        ]);

        User::create([
            'nama' => $this->nama,
            'email' => $this->email,
            'password' => bcrypt($this->password), // Gunakan bcrypt untuk mengenkripsi password
            'jenis' => 'admin'
        ]);

        session()->flash('success', 'Berhasil disimpan!');
        $this->reset();
    }

    public function edit($id)
    {
        // Mencari data user berdasarkan ID
        $user = User::find($id);
    
        // Jika user ditemukan, set data ke dalam selectedUser
        if ($user) {
            $this->selectedUser = [
                'id' => $user->id,
                'nama' => $user->nama,
                'email' => $user->email,
                'password' => '',  // Kosongkan password jika tidak ingin menampilkan password sebelumnya
            ];
        } else {
            session()->flash('error', 'User tidak ditemukan!');
        }
    }
    

    public function update()
    {
        $user = User::find($this->id);

        if ($this->password == "") {
            $user->update([
                'nama' => $this->nama,
                'email' => $this->email
            ]);
        } else {
            $user->update([
                'nama' => $this->nama,
                'email' => $this->email,
                'password' => bcrypt($this->password)
            ]);
        }

        session()->flash('success', 'Berhasil diubah!');
        $this->reset();
    }

    public function confirmDelete($id)
    {
        $this->id = $id;
    }

    public function destroy()
    {
        $user = User::find($this->id);
        $user->delete();

        session()->flash('success', 'Berhasil dihapus!');
        $this->reset();
    }
}
