<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Score extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "scores";
    protected $primaryKey = "id";
    protected $fillable = [
        "mark",
        "type",
        "exams_id",
        "student_id",
        "subject_id"
    ];

    protected $appends = ["score_number", "score_string", "subject_name"];

    public function getScoreNumberAttribute()
    {
        if (!is_null($this->theoretical_score) && !is_null($this->midterm_score) && !is_null($this->final_score)) {
            return 0.1 * $this->theoretical_score + 0.3 * $this->midterm_score + 0.6 * $this->final_score;
        }
        return null;
    }

    public function getScoreStringAttribute()
    {
        if (!is_null($this->theoretical_score) && !is_null($this->midterm_score) && !is_null($this->final_score)) {
            $scoreNumber = 0.1 * $this->theoretical_score + 0.3 * $this->midterm_score + 0.6 * $this->final_score;
            if ($scoreNumber > 9) {
                return "A+";
            } elseif ($scoreNumber > 8.5) {
                return "A";
            } elseif ($scoreNumber > 8) {
                return "B+";
            } elseif ($scoreNumber > 7) {
                return "B";
            } elseif ($scoreNumber > 6.5) {
                return "C+";
            } elseif ($scoreNumber > 6) {
                return "C";
            } elseif ($scoreNumber > 5.5) {
                return "D+";
            } elseif ($scoreNumber > 5) {
                return "D";
            } else {
                return "F";
            }
        }
        return null;
    }

    public function getSubjectNameAttribute()
    {
        return Subject::find($this->subject_id)->name;
    }
}
