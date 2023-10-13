<?php

namespace App\Services;

use App\Models\Area;
use App\Models\City;
use App\Models\Warehouse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class NovaPoshtaService
{
    public function get($calledMethod, $page, $limit)
    {
        $requestPayload = [
            "modelName" => "Address",
            "calledMethod" => "$calledMethod",
            "methodProperties" => [
                "Page" => $page,
                "Limit" => $limit,
            ]
        ];
        return Http::post("https://api.novaposhta.ua/v2.0/json/Address/$calledMethod", $requestPayload)->json()['data'];
    }
    public function getAreas()
    {
        $requestPayload = [
            "modelName" => "Address",
            "calledMethod" => "getAreas",
        ];
        return Http::post("https://api.novaposhta.ua/v2.0/json/Address/getAreas", $requestPayload)->json();
    }
    public function updateOrCreateCities($cities)
    {
        foreach ($cities as $city) {
            City::updateOrCreate(
                ['id' => $city['Ref']],
                [
                    'name' => $city['Description'],
                    'area_id' => $city['Area'],
                ]
            );
        }
    }

    public function updateOrCreateAreas($areas)
    {
        foreach ($areas as $area) {
            Area::updateOrCreate(
                [
                    'id' => $area['Ref'],
                ],
                [
                    'name' => $area['Description'],
                ]
            );
        }
    }
    public function updateOrCreateWarehouses($warehouses)
    {
        foreach ($warehouses as $warehouse) {
            Warehouse::updateOrCreate(
                [
                    'id' => $warehouse['Ref']
                ],
                [
                    'address' => $warehouse['Description'],
                    'city_id' => $warehouse['CityRef'],
                    'number' => $warehouse['Number'],
                ]
            );
        }
    }
}
