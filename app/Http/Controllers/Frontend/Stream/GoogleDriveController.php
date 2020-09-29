<?php

namespace App\Http\Controllers\Frontend\Stream;

use App\Helpers\GoogleDrive;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;

class GoogleDriveController extends Controller
{
    public function stream($file, $quality = '360p') {
        $stream = json_decode(Crypt::decryptString(base64_decode(urldecode($file))));
        $gdrive = new GoogleDrive();
        $gdrive->stream($stream->file, $quality);
        die();
    }
}