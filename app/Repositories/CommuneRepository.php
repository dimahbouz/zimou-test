<?php

namespace App\Repositories;

use App\Helpers\StaticFunctions;
use App\Models\Commune;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class CommuneRepository
{
    public function index(Request $request): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return Commune
            ::when($request->has('id'), function (Builder $query) use ($request) {
                $query->where('id', '=', $request->get('id'));
            })
            ->when($request->has('name'), function (Builder $query) use ($request) {
                $query->where('name', 'LIKE', '%' . $request->get('name') . '%');
            })
            ->when($request->has('wilayaId'), function (Builder $query) use ($request) {
                $query->where('wilaya_id', '=', $request->get('wilayaId'));
            })
            ->paginate(StaticFunctions::getPerPageValueFromRequest($request))
            ->withQueryString();
    }
}
