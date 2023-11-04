<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = [
            'Apple', 'Samsung', 'Xiaomi', 'Sony', 'LG',
            'Huawei', 'Lenovo', 'Asus', 'Nokia', 'HTC',
            'Motorola', 'Google', 'OnePlus', 'Oppo', 'Vivo',
            'Logitech', 'Razer', 'SteelSeries', 'Canon', 'Nikon',
            'Bose', 'JBL', 'Sennheiser', 'Garmin', 'Casio',
            'Microsoft', 'Amazon', 'Epson', 'Nvidia', 'GoPro',
            // 'Philips', 'TCL', 'ZTE', 'Alcatel', 'T-Mobile',
            // 'Fujitsu', 'Meizu', 'BlackBerry', 'Acer', 'Dell',
            // 'HP', 'Toshiba', 'Panasonic', 'Sharp', 'Mitsubishi',
            // 'Subaru', 'Toyota', 'Honda', 'BMW', 'Mercedes-Benz',
            // 'Audi', 'Volkswagen', 'Ford', 'IKEA', 'Herman Miller',
            // 'LEGO', 'Hasbro', 'Play-Doh', 'Mattel', 'Fisher-Price',
            // 'Sony Pictures', 'Universal Pictures', 'Warner Bros.', 'Paramount Pictures', '20th Century Studios',
        ];
        $images = Storage::files('fakeImages/brands');
        foreach ($brands as $brand) {
             $brand = Brand::create([
                'name' => $brand,
                'slug' => str()->slug($brand),
            ]);
            $brand->image()->create([
                'order' => 1,
                'disk' => 'local',
                'path' => $images[fake()->numberBetween(0, count($images) - 1)],
            ]);
        }
    }
}
