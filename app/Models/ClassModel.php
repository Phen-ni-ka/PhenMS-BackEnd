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
        "name",
        "max_students",
        "subject_id",
        "teacher_id",
        "status"
    ];

    protected $appends = ['teacher_name', 'avatar_url', 'class_name', 'remain_slot', 'status_string', 'student_class_status_string'];

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

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function getTeacherNameAttribute()
    {
        if (is_null($this->teacher)) {
            return "";
        }
        return $this->teacher->fullname;
    }

    public function getAvatarUrlAttribute()
    {
        if (is_null($this->teacher)) {
            return "";
        }
        return $this->teacher->avatar_url;
    }

    public function getClassNameAttribute()
    {
        return $this->subject->name . "_" . $this->name;
    }

    public function getRemainSlotAttribute()
    {
        $subscribedQuantity = StudentClass::where("class_id")->count();
        return $this->max_students - $subscribedQuantity;
    }

    public function getStatusStringAttribute()
    {
        return (new Helper)->commonStr(self::STATUS_LIST, $this->status);
    }

    public function getStudentClassStatusStringAttribute()
    {
        if (!is_null($this->student_class_status_id)) {
            return (new Helper)->commonStr(StudentClass::STATUS_LIST, $this->student_class_status_id);
        }
    }

    public function getSubscribedClasses()
    {
        $loginedStudentId = (new Helper)->getLoginedStudent()->id;

        return self::select("classes.*", "student_classes.status_id as student_class_status_id")->join("student_classes", "student_classes.class_id", "classes.id")
            ->where("student_classes.student_id", $loginedStudentId)
            ->get()->makeHidden(['created_at', 'updated_at', 'deleted_at']);
    }
}
