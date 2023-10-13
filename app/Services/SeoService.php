<?php

namespace App\Services;

use App\Models\Seo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class SeoService
{
    public $title;
    public $description;
    public function generateSeoDynamic(Model $model)
    {
        $seoData = $model->getSeoData();
        
        $this->setSeo($seoData['title'], $seoData['description']);
    }
    public function generateSeo($fullUrl)
    {
        $url = substr($fullUrl, 2);

        $seo = Seo::query()->where('url', $url)->first();

        if (!$seo) {
           return $this->setSeo();
        }

        $this->setSeo($seo->title, $seo->description);
    }
    private function setSeo($title = null, $description = null)
    {
        $this->title = $title ?? config('seo.title');

        $this->description = $description ?? config('seo.description');
    }
    public function html()
    {
        return view('seo.index', [
            'title' => $this->title,
            'description' => $this->description,
        ])->render();
    }
}
