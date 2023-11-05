<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Issue extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "issues";
    protected $primaryKey = "id";
    protected $fillable = [
        "title",
        "detail",
        "status_id",
        "student_id",
    ];

    protected $appends = ["status_string", "student_name", "student_email", "student_school_year", "student_code"];

    const STATUS_SENT = 1;
    const STATUS_PROCESSING = 2;
    const STATUS_ACCEPT = 3;
    const STATUS_CANCEL = 4;

    const STATUS_LIST = [
        self::STATUS_SENT => "Đã gửi",
        self::STATUS_PROCESSING => "Đang xem xét",
        self::STATUS_ACCEPT => "Đã duyệt",
        self::STATUS_CANCEL => "Đã hủy",
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function getStatusStringAttribute()
    {
        return (new Helper)->commonStr(self::STATUS_LIST, $this->status_id);
    }

    public function getStudentNameAttribute()
    {
        return $this->student->fullname;
    }

    public function getStudentEmailAttribute()
    {
        return $this->student->email;
    }

    public function getStudentSchoolYearAttribute()
    {
        return "K" . $this->student->school_year;
    }

    public function getStudentCodeAttribute()
    {
        return $this->student->student_code;
    }
}
