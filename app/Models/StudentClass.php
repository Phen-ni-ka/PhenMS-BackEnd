<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentClass extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "student_classes";
    protected $primaryKey = "id";
    protected $fillable = [
        "student_id",
        "class_id",
    ];
}
