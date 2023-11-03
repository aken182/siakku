<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
        'id_anggota',
        'username',
        'password',
        'status',
        'first_login_today',
        'second_login_today',
        'last_login_at',
        'foto'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'id_anggota');
    }

    // inisiasi flag login
    public function updateFirstLoginToday()
    {
        $this->first_login_at = false;
        $this->second_login_at = false;
        $this->save();
    }

    public static function checkFirstLoginToday()
    {
        $user = Auth::user();
        $today = now('Asia/Singapore')->format('Y-m-d');
        $currentTime = now('Asia/Singapore')->format('H');

        if ($user->last_login_at < $today) {
            if ($currentTime >= 6 && $user->last_login_today == false) {
                $user->first_login_today = true;
                $user->last_login_at = now();
                $user->save();
                return true;
            } elseif ($currentTime >= 12 && $user->first_login_today == true && $user->second_login_today == false) {
                $user->second_login_today == true;
                $user->last_login_at = now();
                $user->save();
                return true;
            } else {
                $user->first_login_today = false;
                $user->second_login_today = false;
            }
        }

        // return false;
    }
}
