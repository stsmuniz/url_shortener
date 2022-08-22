<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class LinkController extends Controller
{
    public function redirect(string $shortenedUrl)
    {
        $link = Link::where([
            ['shortened_url', $shortenedUrl],
            ['active', true],
        ])
            ->firstOr(fn() => abort(404));

        if ($link->increment('access_count')) {
            return redirect()->away($link->original_url);
        }
    }

    public function generateQrCode(string $shortenedUrl)
    {
        $link = Link::where('shortened_url', $shortenedUrl)
            ->firstOr(fn() => abort(404));

        return QrCode::generate($link->shortened_url);
    }
}
