<?php

namespace App\Services;

use App\Models\Ad;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Illuminate\Support\Facades\Storage;

class QrCodeService
{
    public function generateForAd(Ad $ad): string
    {
        $url = config('app.url').'/ad/'.$ad->id;

        logger('QR URL: '.$url);

        $renderer = new ImageRenderer(
            new RendererStyle(300),
            new SvgImageBackEnd
        );

        $writer = new Writer($renderer);
        $svg = $writer->writeString($url);

        $filename = 'qr_codes/ad_'.uniqid().'.svg';

        Storage::disk('public')->put($filename, $svg);

        return 'storage/'.$filename;
    }
}
