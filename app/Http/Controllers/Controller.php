<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\File;
use Image;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function responseError($error = NULL, $msg = 'Bad Request', $statusCode = 400) {
        return response()->json([
            'status' => false,
            'message'=> $msg,
            'error' => $error
        ], $statusCode);
    }

    public function responseSuccess($data = NULL, $msg = 'Successful', $statusCode = 200) {
        return response()->json([
            'status' => true,
            'message' => $msg,
            'data' => $data
        ], $statusCode);
    }

    public function uploadFiles($config){
        
        $file = isset($config['file']) ? $config['file'] : NULL; 
        $filename = isset($config['name']) ? $config['name'] : str_random(10); 
        $path = isset($config['path']) ?  $config['path'] : '' ;
        $type = isset($config['type']) ? $config['type'] : NULL;
        $allowFileTypes = isset($config['allow']) ? $config['allow'] : NULL;
        $resize = isset($config['resize']) ? $config['resize'] : NULL;
        $resize_mode = isset($config['resize_mode']) ? $config['resize_mode'] : NULL;
        $rasio = isset($config['rasio']) ? $config['rasio'] : ['width' => 100, 'height' => 100];
        $storagePath = public_path('assets'. $path .'/');
        $imageAsset = 'assets/images';
        $documentAsset = 'assets/documents';
        $otherFileAsset = 'assets/files';
        $saveGallery = NULL;
        
        switch($type){
            case 'images':
                $savePath = $imageAsset . $path .'/';
                $storagePath = public_path($savePath);
                $saveGallery = $savePath;
                if(!$allowFileTypes) $allowFileTypes = ['jpeg', 'jpg', 'JPG', 'JPEG', 'png', 'PNG'];
                break;
            case 'documents':
                $savePath = $documentAsset . $path .'/';
                $storagePath = public_path($savePath);
                $saveGallery = $savePath;
                if(!$allowFileTypes) $allowFileTypes = ['pdf', 'doc', 'docx', 'xs','xsx','txt', 'ppt', 'pptx'];
                break;
            default:
                $savePath = $otherFileAsset . $path .'/';
                $storagePath = public_path($savePath);
                $saveGallery = $savePath;
                break;
        }

        if(!$file || !$filename || !$path) return NULL;

        if($allowFileTypes){
            $isAllowed = false;
            foreach($allowFileTypes as $val){
                if($file->getClientOriginalExtension() === $val){
                    $isAllowed = true;
                }
            }
            if(!$isAllowed) $this->responseError(NULL, 'Jenis file tidak diizinkan!');
        }

        if(!File::exists($storagePath)) File::makeDirectory($storagePath, 775);
        
        if($type === 'images' && $resize) {

            $image = Image::make($file);
            
            switch($resize_mode){
                case 'fit':
                    $resize_image = $image->fit($rasio['width'], $rasio['height'], function($constraint){
                        $constraint->aspectRatio();
                    });
                    break;
                default:
                    $resize_image = $image->resize($rasio['width'], $rasio['height'], function($constraint){
                        $constraint->aspectRatio();
                    });
                    break;
            }

            $upload = $resize_image->save($storagePath . $filename);
        } else {
            $upload = $file->move($storagePath, $filename);
        }

        
        if(!$upload) return NULL;
        $saveGallery = $saveGallery . $filename;
        $response = [
            'upload' => $upload,
            'file' => $file,
            'filename' => $filename,
            'savepath' => $storagePath,
            'gallerypath' => $saveGallery,
            'extension' => $file->getClientOriginalExtension(),
        ];

        return $response;
    }


    public function deleteFile($file = NULL) {
        if(!$file) return NULL;
        $delete = File::delete($file);
        return $delete;
    }
}
