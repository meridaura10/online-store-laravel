<?php

namespace App\Actions;

use App\Models\Sku;

class AlsoGet
{
    static public function handle($skuId = null)
    {
        if ($alsoIds = session()->get('also')) {

            if ($skuId) {
                $alsoIds = array_filter($alsoIds, function ($i) use ($skuId) {
                    return $i !== $skuId;
                });
            }

            return Sku::query()
                ->with(
                    'bannerImage',
                    'values.translations',
                    'product.translations'
                )
                ->whereIn('id', $alsoIds)
                ->limit(6)
                ->get();
        }
        return [];
    }
}
