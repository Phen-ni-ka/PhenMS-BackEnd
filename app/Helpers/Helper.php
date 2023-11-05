<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;

class Helper
{
    public function getLoginedStudent()
    {
        return Auth::guard("students")->user();
    }

    public function commonStr($listStatus, $typeStatus)
    {
        if (isset($listStatus[$typeStatus])) {
            return $listStatus[$typeStatus];
        }

        return null;
    }
}
