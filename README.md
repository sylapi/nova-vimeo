# Nova Vimeo

## Installation

Install the package in to a Laravel app that uses Nova via composer:

```
composer require sylapi/nova-vimeo
```

Publish the package configuration to your Laravel config directory:

```
php artisan vendor:publish --provider="Sylapi\Vimeo\FieldServiceProvider" --tag="config"
```

You need to type your VIMEO API Credentials in the .env file as follows:

```
VIMEO_CLIENT_ID=VimeoClientId
VIMEO_SECRET=VimeoSecret
VIMEO_TOKEN=VimeoToken
```

## Usage

```
Vimeo::make(___('Vimeo'))->nullable()
    ->hideFromIndex()
    ->fields([
        'thumbnail' => [
            'name' => 'Background Vimeo thumbnail',
            'attribute' => 'your_field_video_thumbnail',
            'value' => $this->your_field_video_thumbnail,
        ],
        'vimeo' => [
            'name' => 'Vimeo Video',
            'attribute' => 'your_field_video',
            'value' => $this->your_field_video,
        ],
        'vimeo_hls' => [
            'name' => 'Vimeo Video HLS',
            'attribute' => 'your_field_video_hls',
            'value' => $this->your_field_video_hls,
        ],
        'vimeo_dash' => [
            'name' => 'Vimeo Video DASH',
            'attribute' => 'your_field_video_dash',
            'value' => $this->your_field_video_dash,
        ],
    ]),
```