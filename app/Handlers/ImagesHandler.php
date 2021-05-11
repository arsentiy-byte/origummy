<?php

declare(strict_types=1);

namespace App\Handlers;

use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image as ImageFacade;
use Intervention\Image\Image;

final class ImagesHandler
{
    /**
     * @var string
     */
    private string $format;
    private string $dir;

    /**
     * @var int
     */
    private int $width;
    private int $quality;

    /**
     * ImagesHandler constructor.
     * @param int $width
     * @param string $dir
     * @param string $format
     * @param int $quality
     */
    public function __construct(int $width, string $dir = '', string $format = '', int $quality = 90)
    {
        $this->format = $format;
        $this->width = $width;
        $this->dir = $dir;
        $this->quality = $quality;
    }

    /**
     * @param UploadedFile $file
     * @return array
     */
    public function handleUploadedImage(UploadedFile $file): array
    {
        $fileName = time().'_'.rand();
        $image = $this->resizeImage($file);
        $extension = $file->getClientOriginalExtension();

        if (! empty($this->format)) {
            $image = $this->convert($image);
            $extension = $this->format;
        }

        $dir = $this->dir ? $this->dir.'/' : '';

        return ['path' => "{$dir}{$fileName}.{$extension}", 'data' => $image];
    }

    /**
     * @param Image $image
     * @param string $filePath
     */
    public function storeImage(Image $image, string $filePath): void
    {
        $this->createDirectoryIfNotExists(public_path()."/images/{$this->dir}");
        $path = public_path('images')."/{$filePath}";
        $image->save($path, $this->quality);
    }

    /**
     * @param string $filePath
     * @throws Exception
     */
    public function deleteImage(string $filePath)
    {
        $this->createDirectoryIfNotExists(public_path()."/images/{$this->dir}");
        $path = public_path('images')."/{$filePath}";
        if (! File::exists($path) || ! File::delete($path)) {
            throw new Exception('Failed when deleting file');
        }
    }

    /**
     * @param array $images
     * @return array
     */
    public function handleSeveralImages(array $images): array
    {
        $files = [];
        foreach ($images as $image) {
            $files[] = $this->handleUploadedImage($image);
        }

        return $files;
    }

    /**
     * @param UploadedFile $file
     * @return Image
     */
    private function resizeImage(UploadedFile $file): Image
    {
        $image = ImageFacade::make($file->path());

        $image->resize($this->width, null, function ($constraint) {
            $constraint->aspectRatio();
        });

        return $image;
    }

    /**
     * @param Image $image
     * @return Image
     */
    private function convert(Image $image): Image
    {
        return $image->encode($this->format, 100);
    }

    /**
     * @param string $path
     */
    private function createDirectoryIfNotExists(string $path)
    {
        if (! File::exists($path)) {
            File::makeDirectory($path, 493, true, true);
        }
    }
}
