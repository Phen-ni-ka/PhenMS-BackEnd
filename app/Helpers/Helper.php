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

    public function formatPaginate($data)
    {
        $paginateData = [
            'data' => $data->items(),
            'total' => $data->total(),
            'current_page' => $data->currentPage(),
            'last_page' => $data->lastPage(),
            'per_page' => $data->perPage(),
            'has_more_pages' => $data->hasMorePages(),
        ];
        return $paginateData;
    }
}
