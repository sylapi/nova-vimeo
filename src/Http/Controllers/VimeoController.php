<?php
declare(strict_types=1);

namespace Sylapi\Vimeo\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Sylapi\Vimeo\Exceptions\VimeoException;

class VimeoController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(string $vimeoId): JsonResponse
    {
        $lib = new \Vimeo\Vimeo(config('vimeo.client_id'), config('vimeo.secret'));
        $lib->setToken(config('vimeo.token'));

        try {
            if(!$vimeoId) {
                throw new VimeoException('vimeo_id not found');
            }
    
            $response = $lib->request('/videos/'.$vimeoId, null, 'GET');
    
            if(isset($response['body']['error'])) {
                throw new VimeoException($response['body']['error']);
            }
    
            $videos = [
                'thumbnail' => $response['body']['pictures']['base_link'] ?? null,
                'vimeo' => null,
                'vimeo_hls' => null,
                'vimeo_dash' => null,
            ];
    
            array_map(function($item) use(&$videos) {
                if(isset($item['rendition']) && $item['rendition'] === '1080p') {
                    $videos['vimeo'] = $item['link'] ?? null;
                }
    
                if(isset($item['quality']) && $item['quality'] === 'hls') {
                    $videos['vimeo_hls'] = $item['link'] ?? null;
                }                
    
            }, $response['body']['files'] ?? []);
        
            return response()->json($videos);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 400);
        }

    }
}
