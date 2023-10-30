<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClassModel extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "classes";
    protected $primaryKey = "id";
    protected $fillable = [
        "max_students",
        "subject_id",
        "teacher_id",
        "status"
    ];

    protected $appends = ['teacher_name'];

    const STATUS_UNSCRIBALE = 0;
    const STATUS_SCRIBALE = 1;
    const STATUS_LEARNING = 2;
    const STATUS_END = 3;

    const STATUS_LIST = [
        self::STATUS_UNSCRIBALE => "Không thể đăng ký",
        self::STATUS_SCRIBALE => "Có thể đăng ký",
        self::STATUS_LEARNING => "Đang học",
        self::STATUS_END => "Đã kết thúc",
    ];

    public function getTeacherNameAttribute()
    {
        return Teacher::find($this->teacher_id)->fullname;
    }
}
