<?php

namespace Agentsquidflaps\Picture;

/**
 * Class ImageMimeType
 * @package Agentsquidflaps\Picture
 */
class ImageMimeType
{
    const MIME_TYPES = [
        'bmp' => 'image/bmp',
        'cgm' => 'image/cgm',
        'djvu' => 'image/vnd.djvu',
        'gif' => 'image/gif',
        'ico' => 'image/x-icon',
        'ief' => 'image/ief',
        'jp2' => 'image/jp2',
        'jpeg' => 'image/jpeg',
        'jpg' => 'image/jpeg',
        'pbm' => 'image/x-portable-bitmap',
        'pgm' => 'image/x-portable-graymap',
        'pict' => 'image/pict',
        'png' => 'image/png',
        'pnm' => 'image/x-portable-anymap',
        'pntg' => 'image/x-macpaint',
        'ppm' => 'image/x-portable-pixmap',
        'ras' => 'image/x-cmu-raster',
        'svg' => 'image/svg+xml',
        'tiff' => 'image/tiff',
        'wbmp' => 'image/vnd.wap.wbmp',
        'webp' => 'image/webp'
    ];

    /**
     * @param $extension
     * @return string
     */
    public static function getMimeTypeFromExtension($extension)
    {
        return static::MIME_TYPES[$extension] ?? '';
    }
}
