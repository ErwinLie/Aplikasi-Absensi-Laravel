<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class M_projek extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public static function tampil($tableName)
    {
        return DB::table($tableName)->get(); // Menggunakan Query Builder untuk mengambil semua data dari tabel yang diberikan
    }
    public function tambah($table, $data)
    {
        return DB::table($table)->insert($data); // Using Query Builder for insertion
    }
    public function edit($table, $data, $where)
    {
    return DB::table($table)
              ->where($where)
              ->update($data);
    }
    public function hapus($table, $where)
    {
    return DB::table($table)
              ->where($where)
              ->delete();
    }
    public function join($table, $table2, $on)
    {
    return DB::table($table)
            ->leftJoin($table2, $on[0], '=', $on[1]) // $on is expected as an array with column names
            ->get();
    }

public function getWhere($table, $column) {
    return DB::table($table)->where($column)->first(); // Mengambil data pertama yang cocok
}

public function joinThreeWhere($table, $table2, $table3, $on, $on2, $where)
{
    return DB::table($table)
              ->leftJoin($table2, $on[0], '=', $on[1])
              ->leftJoin($table3, $on2[0], '=', $on2[1])
              ->where($where)
              ->first();
}

public function upload($photo)
{
    // Get the original file name
    $imageName = $photo->getClientOriginalName();

    // Move the uploaded file to the 'public/img' directory
    $photo->move(public_path('img'), $imageName);
}

public function getJadwalByKelasBlok($kelas, $blok)
    {
        return DB::table('tb_jadwal')
    ->join('tb_user', function($join) {
        $join->on('tb_jadwal.id_guru', '=', 'tb_user.id_user');
    })
    ->join('tb_mapel', function($join) {
        $join->on('tb_jadwal.id_mapel', '=', 'tb_mapel.id_mapel');
    })
    ->select('tb_jadwal.sesi', 'tb_user.username', 'tb_mapel.nama_mapel', 'tb_jadwal.jam_mulai', 'tb_jadwal.jam_selesai', 'tb_jadwal.id_guru', 'tb_jadwal.id_jadwal')
    ->where('tb_jadwal.id_kelas', $kelas)
    ->where('tb_jadwal.id_blok', $blok)
    ->get();
    }

}