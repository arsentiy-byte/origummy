<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Handlers\ImagesHandler;
use App\Http\Controllers\Controller;
use DB;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class BannersController.
 */
final class BannersController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function manageBanners(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'banners' => 'nullable|array',
            'banners.*' => 'image|mimes:jpeg,png,jpg,svg',
            'delete_banners' => 'nullable|array',
            'delete_banners.*' => 'string',
        ], $request->all());

        $imagesHandler = new ImagesHandler(1280, 'banners');

        if (! empty($validated['delete_banners'])) {
            foreach ($validated['delete_banners'] as $deleteBanner) {
                DB::table('banners')->where('image', $deleteBanner)->delete();
                $imagesHandler->deleteImage($deleteBanner);
            }
        }

        if (! empty($validated['banners'])) {
            $banners = $request->allFiles()['banners'];
            $images = $imagesHandler->handleSeveralImages($banners);

            foreach ($images as $image) {
                $path = $image['path'];
                DB::table('banners')->insert([
                    'image' => $path,
                    'created_at' => now(),
                    'updated_at' => null,
                ]);
                $imagesHandler->storeImage($image['data'], $path);
            }
        }

        return $this->response('Операция успешно выполнена');
    }

    /**
     * @return JsonResponse
     */
    public function getBanners(): JsonResponse
    {
        $banners = DB::table('banners')->select()->get()->toArray();

        return $this->response('Успешно получены', $banners);
    }
}
