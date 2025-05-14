<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SesiController extends Controller
{
    function index()
    {
        return view('login');
    }

    function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ], [
            'email.required' => 'Email Wajib Diisi',
            'password.required' => 'Password Wajib Diisi'
        ]);

        $infologin = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (Auth::attempt($infologin)) {
            if (Auth::user()->role == 'penjual') {
                return redirect('/admin/penjual');
            } elseif (Auth::user()->role == 'pembeli') {
                return redirect('/admin/pembeli');
            } elseif (Auth::user()->role == 'inspektor') {
                return redirect('/admin/inspektor');
            } elseif (Auth::user()->role == 'admin') {
                return redirect('admin');
            }
        } else {
            return redirect('')->withErrors('Email atau Password Salah')->withInput();
        }
    }

    function logout()
    {
        Auth::logout();
        return redirect('');
    }
}
