<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Subject;
use App\Models\SubjectStudent;
use Exception;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function listSubscribaleSubjects()
    {
        try {
            $subscribaleSubject = (new Subject())->getSubcribableSubjects();

            return response()->json($subscribaleSubject, 200);
        } catch (Exception $e) {
            return response()->json([
                "message" => $e->getMessage()
            ], 500);
        }
    }
}