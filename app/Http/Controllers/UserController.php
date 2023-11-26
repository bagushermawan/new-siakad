<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        // Mendapatkan roles dari user
        $roles = $user->getRoleNames();
        // dd($daftar_user->role->nama);
        $daftar_user = User::get();

        return view('admin.user.index', ['roles' => $roles, 'daftar_user' => $daftar_user]);
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }


    public function show(string $id)
    {
        //
    }


    public function edit($id)
    {
        $user = Auth::user();
        // Mendapatkan roles dari user
        $roles = $user->getRoleNames();
        $user = User::find($id);
        return view('admin.user.profileEdit', ['user' => $user, 'roles' => $roles]);
    }


    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $user->name = $request->get('name');
        $user->username = $request->get('username');
        $user->email = $request->get('email');
        if ($request->has('password')) {
            $user->password = bcrypt($request->get('password'));
        }

        $user->save();
        return redirect()->route('admin.user.edit', $id)->with('status', 'profile-updated');;
    }


    public function destroy(string $id)
    {
        //
    }
}
