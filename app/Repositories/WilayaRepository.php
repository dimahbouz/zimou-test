<?php

namespace App\Repositories;

use App\Helpers\StaticFunctions;
use App\Models\Wilaya;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class WilayaRepository
{
    public function index(Request $request): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return Wilaya
            ::when($request->has('id'), function (Builder $query) use ($request) {
                $query->where('id', '=', $request->get('id'));
            })
            ->when($request->has('name'), function (Builder $query) use ($request) {
                $query->where('name', 'LIKE', '%' . $request->get('name') . '%');
            })
            ->paginate(StaticFunctions::getPerPageValueFromRequest($request))
            ->withQueryString();
    }
}
