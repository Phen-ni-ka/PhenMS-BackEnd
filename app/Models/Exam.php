<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Exam extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "exams";
    protected $primaryKey = "id";
    protected $fillable = [
        "date",
        "type",
        "start_time",
        "end_time",
        "subject_id",
        "student_id"
    ];

    protected $appends = ['subject_name', 'type_string'];

    const TYPE_PRACTICE = 1;
    const TYPE_ESSAY = 2;

    const TYPE_LIST = [
        self::TYPE_PRACTICE => "Thực hành phòng máy",
        self::TYPE_ESSAY => "Tự luận viết giấy"
    ];

    public function getSubjectNameAttribute()
    {
        return Subject::find($this->subject_id)->name;
    }

    public function getTypeStringAttribute()
    {
        return (new Helper)->commonStr(self::TYPE_LIST, $this->type);
    }
}
