<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class login extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'password',
        'email',
        'id_level',
        'foto',
        'jk',
    ];

    protected $table = 'tb_user'; // Nama tabel yang digunakan

    protected $primaryKey = 'id_user'; // Primary key dari tabel

    // Jika tabel tidak memiliki kolom timestamps (created_at, updated_at)
    public $timestamps = false;

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'id_level' => 'string', // enum '1', '2', '3', '4', '5'
        'jk' => 'string',       // enum 'L' atau 'P'
    ];
}