<?php

namespace App\Services;

use App\Models\Seo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class SeoService
{
    public $title;
    public $description;
    public $image;
    public Model $model;
    public $seo;
    public $seoData;
    public $template;

    public function generateSeoDynamic(Model $model)
    {
        $cacheKey = 'seo_' . $model->id;
        $seo = cache()->remember($cacheKey, now()->addHours(24), function () use ($model) {
            $this->model = $model;
            $this->seo = $model->seo;
            $this->seoData = $model->getSeoData();
            $this->template = $this->getTemplate($this->seoData['url']);
            $title = $this->getTitle();
            $description = $this->getDescription();
            $image = $this->seoData['image'];
            return [
                'title' => $title,
                'description' => $description,
                'image' => $image,
            ];
        });
        $this->setSeo(...$seo);
    }

    public function parseSeoTemplate($field)
    {
        return str()->replace(
            [
                '{name}',
                '{description}',
            ],
            [
                $this->seoData['title'],
                $this->seoData['description'],
            ],
            $field,
        );
    }

    public function getTitle()
    {
        return $this->getField('title');
    }

    public function getTemplate($url)
    {
        return Seo::query()->where('url', $url)->with('translations')->first();
    }

    public function getDescription()
    {
        return $this->getField('description');
    }

    public function getField($fieldName)
    {

        $field = $this->model->seo?->{$fieldName};

        if ($field) {
            return $this->parseSeoTemplate($field);
        }

        if ($this->template) {
            return $this->parseSeoTemplate($this->template->{$fieldName});
        }

        return $this->seoData[$fieldName];
    }

    public function generateSeo($fullUrl)
    {
        $url = parse_url(substr($fullUrl, 2), PHP_URL_PATH);
        $seo = cache()->remember($url ? $url : '/', now()->addHours(24), function () use ($url) {
           return Seo::query()->where('url', $url ? $url : '/')->with('translations')->first();
        });

        if (!$seo) {
            return $this->setSeo();
        }

        $this->setSeo($seo->title, $seo->description);
    }

    private function setSeo($title = null, $description = null,$image = null)
    {
        $this->title = $title ? $title : config('seo.title');       
        $this->image = $image ? $image : config('seo.image');
        $this->description = $description ? $description :   config('seo.description');
    }

    public function html()
    {
        return view('seo.index', [
            'title' => $this->title,
            'description' => $this->description,
            'image' => $this->image,
        ])->render();
    }
}
