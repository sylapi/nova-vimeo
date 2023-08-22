<?php

namespace Sylapi\Vimeo;

use Laravel\Nova\Fields\Field;
use Laravel\Nova\Http\Requests\NovaRequest;

class Vimeo extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'vimeo';


    protected $thumbnail;
    protected $vimeo;
    protected $vimeo_hls;
    protected $vimeo_dash;

    public function __construct($name, $attribute = null, $resolveCallback = null)
    {
        parent::__construct($name, $attribute, $resolveCallback);

        $this->setAttributes(
            $this->thumbnail,
            $this->vimeo,
            $this->vimeo_hls,
            $this->vimeo_dash,
        );
    }

    public function fields($fields)
    {
       $this->setAttributes(
            $fields['thumbnail']['attribute'],
            $fields['vimeo']['attribute'],
            $fields['vimeo_hls']['attribute'],
            $fields['vimeo_dash']['attribute']
        );
        return $this->withMeta([
            'fields' => $fields,
        ]);
    }




    private function setAttributes(?string $thumbnail, ?string $vimeo, ?string $vimeoHls, ?string $vimeoDash)
    {
        $this->thumbnail  = $thumbnail  ?? 'thumbnail';
        $this->vimeo = $vimeo ?? 'vimeo';
        $this->vimeo_hls = $vimeoHls  ?? 'vimeo_hls';
        $this->vimeo_dash = $vimeoDash ?? 'vimeo_dash';

        return $this->withMeta([
            'thumbnail_attr' => $this->thumbnail,
            'vimeo_attr' => $this->vimeo,
            'vimeo_hls_attr' => $this->vimeo_hls,
            'vimeo_dash_attr' => $this->vimeo_dash,
        ]);
    }

    protected function fillAttributeFromRequest(NovaRequest $request, $requestAttribute, $model, $attribute)
    {
        $model->setAttribute($this->thumbnail, $request->get($this->thumbnail));
        $model->setAttribute($this->vimeo, $request->get($this->vimeo));
        $model->setAttribute($this->vimeo_hls, $request->get($this->vimeo_hls));
        $model->setAttribute($this->vimeo_dash, $request->get($this->vimeo_dash));
    }    
}
