<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SinhVien;

class SinhVienController extends Controller
{
    // SELECT
    public function index()
    {
        $danhSachSV = SinhVien::all();
        return view('sinhvien.list', compact('danhSachSV'));
    }

    // INSERT
    public function store(Request $request)
    {
        SinhVien::create($request->all());
        return redirect()->route('sinhvien.index');
    }
}
