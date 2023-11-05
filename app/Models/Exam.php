<?php

namespace App\Models;

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

    protected $appends = ['subject_name'];

    const TYPE_PRACTICE = "Thực hành phòng máy";
    const TYPE_ESSAY = "Tự luận viết giấy";

    public function getSubjectNameAttribute()
    {
        return Subject::find($this->subject_id)->name;
    }
}
