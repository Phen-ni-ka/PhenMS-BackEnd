<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Student extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'email',
        'email_verified_at',
        'fullname',
        'password',
        'student_code',
        'gender',
        'identity_code',
        'date_of_birth',
        'phone_number',
        'birthplace',
        'home_town',
        'ward',
        'district',
        'province',
        'address',
        'status_id',
        'major_id',
    ];

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
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function getClassmates($classId)
    {
        return self::select("students.fullname", "students.student_code")
            ->join("student_classes", "student_classes.id", "students.id")
            ->where("student_classes.id", $classId)->get()
            ->makeHidden("created_at", "updated_at", "deleted_at");
    }
}
