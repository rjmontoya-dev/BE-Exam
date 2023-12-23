<?php

namespace App\Http\Controllers\Api\Video;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{
    public function list(){
       $directory = public_path('player');
        $fileNames = [];

        if (file_exists($directory) && is_dir($directory)) {
            $files = scandir($directory);

            foreach ($files as $file) {
                if ($file !== '.' && $file !== '..') {
                    $fileNames[] = pathinfo($file, PATHINFO_FILENAME);
                }
            }
        }
        return response()->json(['videonames'=>$fileNames]);
    }
}
