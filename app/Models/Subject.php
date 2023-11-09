<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subject extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "subjects";
    protected $primaryKey = "id";
    protected $fillable = [
        "name",
        "total_period_theory",
        "total_period_practice",
        "semester",
        "school_year",
        "credit",
    ];

    public function getSubcribableSubjects()
    {
        $loginedStudent = (new Helper)->getLoginedStudent();

        return self::select("subjects.*")
            ->join("classes", "classes.subject_id", "subjects.id")
            ->groupBy("classes.subject_id")
            ->where("subjects.school_year", $loginedStudent->school_year)
            ->where("classes.status", ClassModel::STATUS_SCRIBALE)->get()
            ->makeHidden(['created_at', 'updated_at', 'deleted_at']);
    }
}
