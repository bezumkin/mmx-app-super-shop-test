<?php

namespace MMX\Super\Shop\Controllers;

use Carbon\Carbon;
use MMX\Super\Shop\Models\File;
use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Stream;

class Image extends \Vesp\Controllers\Data\Image
{
    protected string $model = File::class;

    protected function handleFile($file): ?ResponseInterface
    {
        // SVG cannot be processed, so we output it as is
        if ($file->type === 'image/svg+xml') {
            return $this->outputFile($file);
        }

        // GIFs without image manipulations should have no changes to save animation
        if ($file->type === 'image/gif') {
            $properties = $this->getProperties();
            unset($properties['id']);
            if (empty($properties)) {
                return $this->outputFile($file);
            }
        }

        return null;
    }

    protected function outputFile($file): ResponseInterface
    {
        $stream = new Stream($file->getFilesystem()->getBaseFilesystem()->readStream($file->getFilePathAttribute()));

        return $this->response
            ->withBody($stream)
            ->withHeader('Content-Type', $file->type)
            ->withHeader('Content-Length', $file->size)
            ->withHeader('Cache-Control', 'max-age=31536000, public')
            ->withHeader('Expires', Carbon::now()->addYear()->toRfc822String());
    }
}