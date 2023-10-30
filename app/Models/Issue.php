<?php

namespace App\Models;

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
}
