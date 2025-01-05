<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class LoginComponent extends Component
{
    public $email,$password;
    public function render()
    {
        return view('livewire.login-component')->layout('components.layouts.login');
    }
    public function proses()
    {
       $credential=$this->validate([
        'email'=>'required',
        'password'=>'required'
       ],[
         'email.required'=>'Email Tidak Boleh Kosong!',
         'password.required'=>'Password Tidak Boleh Kosong'
       ]);
       if(Auth::attempt($credential)){
        session()->regenerate();
 
        return redirect()->route('home');
       }
       return back()->withErrors([
        'email' => 'Autentikasi gagal',
    ])->onlyInput('email');
    }
    public function keluar()
{
    Auth::logout();
 
   session()->invalidate();
 
   session()->regenerateToken();
    $this->reset();
    return redirect()->route('login');
}
}
