<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MajorSubject extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "majors_subjects";
    protected $primaryKey = "id";
    protected $fillable = [
        "major_id",
        "subject_id"
    ];
}
