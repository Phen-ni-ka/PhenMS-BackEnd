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
        'school_year',
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

    protected $appends = [
        "status_string",
        "gender_string",
        "major_name"
    ];

    const GENDER_MALE = 1;
    const GENDER_FEMALE = 2;

    const GENDER_LIST = [
        self::GENDER_MALE => "Nam",
        self::GENDER_FEMALE => "Nữ"
    ];

    const STATUS_MUST_CHANGE_PASSWORD = 0;
    const STATUS_MUST_UPDATE_PROFILE = 1;
    const STATUS_STUDYING = 2;
    const STATUS_LEFT_SCHOOL = 3;

    const STATUS_LIST = [
        self::STATUS_MUST_CHANGE_PASSWORD => "Cần thay đổi mật khẩu",
        self::STATUS_MUST_UPDATE_PROFILE => "Cần cập nhật thông tin cá nhân",
        self::STATUS_STUDYING => "Đang theo học",
        self::STATUS_LEFT_SCHOOL => "Đã thôi học",
    ];

    public function getStatusStringAttribute()
    {
        return (new Helper)->commonStr(self::STATUS_LIST, $this->status_id);
    }

    public function getGenderStringAttribute()
    {
        return (new Helper)->commonStr(self::GENDER_LIST, $this->gender);
    }

    public function getMajorNameAttribute()
    {
        return Major::find($this->major_id)->name;
    }

    public function getClassmates($classId)
    {
        return self::select("students.*")
            ->join("student_classes", "student_classes.student_id", "students.id")
            ->where("student_classes.class_id", $classId)->get()
            ->makeHidden("created_at", "updated_at", "deleted_at");
    }
}
