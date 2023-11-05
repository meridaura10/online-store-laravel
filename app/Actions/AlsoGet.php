<?php

namespace App\Actions;

use App\Models\Sku;

class AlsoGet
{
    static public function handle($productId = null)
    {
        if ($alsoIds = session()->get('also')) {
            if ($productId) {
                $alsoIds = array_filter(array_keys($alsoIds), function ($i) use ($productId) {
                    return $i !== $productId;
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
