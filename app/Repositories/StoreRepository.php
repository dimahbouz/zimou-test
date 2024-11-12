<?php

namespace App\Repositories;

use App\Helpers\StaticFunctions;
use App\Models\Store;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class StoreRepository
{
    public function index(Request $request): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $packageQuery = Store::query();
        $packageQuery->when($request->has('id'), function (Builder $query) use ($request) {
            $query->where('id', '=', $request->get('id'));
        });
        $packageQuery->when($request->has('name'), function (Builder $query) use ($request) {
            $query->where('name', 'LIKE', "%" . $request->get('name') . "%");
        });
        return $packageQuery
            ->paginate(StaticFunctions::getPerPageValueFromRequest($request))
            ->withQueryString();
    }
}
