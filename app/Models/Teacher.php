<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Teacher extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "teachers";
    protected $primaryKey = "id";
    protected $fillable = [
        'email',
        'fullname',
        'teacher_code',
        'academic_level',
        'position',
        'department',
        'resume',
        'major_id',
    ];

    protected $appends = [
        "major_name"
    ];

    public function getMajorNameAttribute()
    {
        return Major::find($this->major_id)->name;
    }
}
