<?php

namespace App\Repositories;

use App\Helpers\StaticFunctions;
use App\Models\DeliveryType;
use App\Models\Package;
use App\Models\PackageStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class PackageRepository
{
    public function index(Request $request): \Illuminate\Database\Eloquent\Collection|\Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $packageQuery = Package::query();
        $packageQuery->when($request->has('storeId'), function (Builder $query) use ($request) {
            $query->where('store_id', '=', $request->get('storeId'));
        });
        $packageQuery->when($request->has('wilayaId'), function (Builder $query) use ($request) {
            $query->whereRelation('commune', 'wilaya_id', '=', $request->get('wilayaId'));
        });
        $packageQuery->when($request->has('communeId'), function (Builder $query) use ($request) {
            $query->where('commune_id', '=', $request->get('communeId'));
        });
        $packageQuery->when($request->has('deliveryTypeId'), function (Builder $query) use ($request) {
            $query->where('delivery_type_id', '=', $request->get('deliveryTypeId'));
        });
        $packageQuery->when($request->has('packageStatusId'), function (Builder $query) use ($request) {
            $query->where('status_id', '=', $request->get('packageStatusId'));
        });
        $packageQuery->when($request->has('trackingCode'), function (Builder $query) use ($request) {
            $query->where('tracking_code', '=', $request->get('trackingCode'));
        });
        $packageQuery->with(['store', 'commune.wilaya', 'delivery_type', 'package_status']);
        if ($request->has('export') and $request->get('export') == 'all') {
            return $packageQuery->get();
        } else {
            return $packageQuery
                ->paginate(StaticFunctions::getPerPageValueFromRequest($request))
                ->withQueryString();
        }
    }

    public function indexDeliveryTypes(Request $request): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return DeliveryType
            ::when($request->has('id'), function (Builder $query) use ($request) {
                $query->where('id', '=', $request->get('id'));
            })
            ->when($request->has('name'), function (Builder $query) use ($request) {
                $query->where('name', 'LIKE', '%' . $request->get('name') . '%');
            })
            ->paginate(StaticFunctions::getPerPageValueFromRequest($request))
            ->withQueryString();
    }

    public function indexPackageStatuses(Request $request): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return PackageStatus
            ::when($request->has('id'), function (Builder $query) use ($request) {
                $query->where('id', '=', $request->get('id'));
            })
            ->when($request->has('name'), function (Builder $query) use ($request) {
                $query->where('name', 'LIKE', '%' . $request->get('name') . '%');
            })
            ->paginate(StaticFunctions::getPerPageValueFromRequest($request))
            ->withQueryString();
    }

    public function store(Request $request): \Illuminate\Database\Eloquent\Model|Package
    {
        return Package::create($request->only(['uuid', 'tracking_code', 'status_id', 'name', 'store_id', 'client_first_name', 'client_last_name', 'client_phone', 'client_phone2', 'address', 'commune_id', 'delivery_type_id', 'can_be_opened', 'free_delivery', 'delivery_price', 'price', 'price_to_pay', 'total_price', 'cod_to_pay', 'commission', 'extra_weight_price', 'packaging_price', 'partner_cod_price', 'partner_delivery_price', 'partner_return', 'return_price', 'weight']));
    }
}
