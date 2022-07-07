<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Opd;
use App\Models\Unitkerja;
use App\Models\Jabatan;
use Illuminate\Http\Request;
use Hash;
use Alert;
use Validator;

class UserController extends Controller
{
    
    protected $messages = [
        'required' => ':attribute wajib diisi!',
        'min' => ':attribute harus diisi minimal :min karakter!',
        'max' => ':attribute harus diisi maksimal :max karakter!',
        'numeric' => ':attribute hanya boleh diisi angka!',
        'file' => ':attribute belum dipilih!',
        'mimes' => 'Format :attribute yang dipilih adalah .JPG, .PNG, .JPEG!',
        'email' => ':attribute hanya boleh diisi menggunakan email!'
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::join('roles','users.id_role','roles.id')
                ->join('jabatans','users.id_jabatan','jabatans.id')
                ->join('unitkerjas','jabatans.id_unitkerja','unitkerjas.id')
                ->join('opds','unitkerjas.id_opd','opds.id')
                ->select('users.*', 'roles.nama_role', 'jabatans.nama_jabatan', 'opds.nama_opd')
                ->get();
        
        return view('adminkab.pengguna.index',
        [
            'user' => $user
            ]
            )
            ->with('no',1);
        }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $role = Role::orderBy('id', 'asc')->get();
        $opd = Opd::orderBy('id', 'asc')->get();
        // $opd = Opd::pluck('nama_opd', 'id');
        // $unitkerja = Unitkerja::orderBy('id', 'asc')->get();
        $jabatan = Jabatan::orderBy('id', 'asc')->get();

        return view('adminkab.pengguna.add',
            [
                'role' => $role,
                'opd' => $opd,
                // 'unitkerja' => $unitkerja,
                'jabatan' => $jabatan
            ]
        );
    }
    
    public function getUnitkerja(Request $request, $id)
    {
        $unitkerja = Unitkerja::where('id_opd', $id)->get();
        // $unitkerja = Unitkerja::where('id_opd', $id)->pluck('nama_unitkerja', 'id');

        return response()->json($unitkerja);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->messages, [
            'nip' => ['required', 'numeric'],
            'nik' => ['required', 'numeric'],
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'no_hp' => ['required', 'numeric'],
            'username' => ['required', 'min:5', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'role' => ['required'],
            'jabatan' => ['required'],
            'pangkat' => ['required'],
            'jenis_user' => ['required'],
            // 'foto' => ['max:2048', 'mimes:jpeg,png,jpg'],
            'foto' => 'mimes:jpeg,png,jpg | max:2048',
        ]);
        
        $user = new User;

        $user->id_role      = $request->role;
        $user->nip          = $request->nip;
        $user->nik          = $request->nik;
        $user->nama         = $request->nama_lengkap;
        $user->no_hp         = $request->no_hp;
        $user->username     = $request->username;
        $user->email        = $request->email;
        $user->password     = Hash::make($request->password);
        $user->id_jabatan   = $request->jabatan;
        $user->pangkat      = $request->pangkat;
        $user->jenis_user   = $request->jenis_user;
        $user->active       = 1;

        if($request->file('foto') == "") {
            $user->foto = 'user.jpg';
        } else {
            $file = $request->file('foto');
            $path = base_path() . '/public/assets/img/profil';
            $nama = $user->username;
            $extension = $file->getClientOriginalExtension();
            $namabaru = $nama . '.' . $extension;
            $file->move($path, $namabaru);

            $user->foto = $namabaru;
        }

        $user->save();

        // Alert::success('Sukses', 'Data pengguna baru berhasil ditambahkan.');

        return redirect('users');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::join('roles','users.id_role','roles.id')
                ->join('jabatans','users.id_jabatan','jabatans.id')
                ->join('unitkerjas','jabatans.id_unitkerja','unitkerjas.id')
                ->join('opds','unitkerjas.id_opd','opds.id')
                ->select('users.*', 'roles.nama_role', 'jabatans.nama_jabatan', 'opds.nama_opd')
                ->where('users.id',$id)
                ->first();
        
        return view('adminkab.pengguna.detail',
            [
                // 'role' => $role,
                'user' => $user
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::orderBy('id', 'asc')->get();
        $opd = Opd::orderBy('id', 'asc')->get();
        // $opd = Opd::pluck('nama_opd', 'id');
        // $unitkerja = Unitkerja::orderBy('id', 'asc')->get();
        $jabatan = Jabatan::orderBy('id', 'asc')->get();

        $user = User::join('roles','users.id_role','roles.id')
                ->join('jabatans','users.id_jabatan','jabatans.id')
                ->join('unitkerjas','jabatans.id_unitkerja','unitkerjas.id')
                ->join('opds','unitkerjas.id_opd','opds.id')
                ->select('users.*', 'roles.nama_role', 'jabatans.nama_jabatan', 'opds.nama_opd', 'unitkerjas.nama_unitkerja')
                ->where('users.id',$id)
                ->first();
        
        return view('adminkab.pengguna.edit',
            [
                // 'role' => $role,
                'user' => $user,
                'role' => $role,
                'opd' => $opd,
                // 'unitkerja' => $unitkerja,
                'jabatan' => $jabatan
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, $this->messages, [
            'nip' => ['required', 'numeric'],
            'nik' => ['required', 'numeric'],
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'no_hp' => ['required', 'numeric'],
            'username' => ['min:5', 'unique:users'],
            'email' => ['string', 'email', 'max:255', 'unique:users'],
            'password' => ['string', 'min:8'],
            'foto' => 'mimes:jpeg,png,jpg | max:2048',
        ]);

        $user = User::findOrFail($id);

        $user->nip          = $request->nip;
        $user->nik          = $request->nik;
        $user->nama         = $request->nama_lengkap;
        $user->no_hp        = $request->no_hp;
        $user->username     = $request->username;
        $user->email        = $request->email;

        
        if($request->password == "") {
            $user->password = $user->password;
        } else {
            $user->password     = Hash::make($request->password);
        }
        
        if($request->role == "") {
            $user->id_role = $user->id_role;
        } else {
            $user->id_role      = $request->role;
        }

        if($request->id_jabatan == "") {
            $user->id_jabatan = $user->id_jabatan;
        } else {
            $user->id_jabatan   = $request->jabatan;
        }

        if($request->pangkat == "") {
            $user->pangkat = $user->pangkat;
        } else {
            $user->pangkat      = $request->pangkat;
        }

        if($request->jenis_user == "") {
            $user->jenis_user = $user->jenis_user;
        } else {
            $user->jenis_user   = $request->jenis_user;
        }

        $user->active       = 1;

        if($request->file('foto') == "") {
            $user->foto = $user->foto;
        } else {
            $file = $request->file('foto');
            $path = base_path() . '/public/assets/img/profil';
            $nama = $user->username;
            $extension = $file->getClientOriginalExtension();
            $namabaru = $nama . '.' . $extension;
            $file->move($path, $namabaru);

            $user->foto = $namabaru;
        }

        $user->update();

        // Alert::success('Sukses', 'Data berhasil diubah.');

        return redirect('users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
