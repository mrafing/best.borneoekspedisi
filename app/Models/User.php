<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Traits\Mutator\GenUid;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, GenUid;                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    // protected $casts = [
    //     'email_verified_at' => 'datetime',
    // ];

    public static function getUsername($kode_agen) {
        // Dapatkan pengguna yang sedang login
        $baseKodeAgen = $kode_agen; // Misalnya: PNK001P

        // Temukan urutan terakhir dari username yang sudah ada dengan prefix yang sama
        $lastUser = User::where('username', 'like', "$baseKodeAgen%")
                        ->orderBy('username', 'desc')
                        ->first();
        
        $newUrutan = '001';

        if (strlen($lastUser->username) > 7) {
            $lastUrutan = (int) substr($lastUser->username, -3);
            $newUrutan = str_pad($lastUrutan + 1, 3, '0', STR_PAD_LEFT); // Tambahkan 1 dan pad dengan 0 di kiri
        }
        
        return $baseKodeAgen . $newUrutan;
    }

    public function outlet () {
        return $this->belongsTo(Outlet::class, 'id_outlet', 'id');
    }
}
