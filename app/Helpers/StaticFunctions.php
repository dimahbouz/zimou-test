<?php

namespace App\Helpers;

use Illuminate\Http\Request;

class StaticFunctions
{
    public static function getPerPageValueFromRequest(Request $request, int $maxPerPage = 30, int $defaultPerPage = 15): int
    {
        if ($request->has('perPage') and is_numeric($request->perPage) and $request->perPage > 0 and $request->perPage <= $maxPerPage)
            return (int)$request->perPage;
        return $defaultPerPage;
    }
}
