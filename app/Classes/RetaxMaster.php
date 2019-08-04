<?php

namespace App\Classes;

class RetaxMaster {
    
    //Sube una imagen
    public static function uploadImage(object $image) : array {
        //Primero subo la imagen
        $supported_files = ["image/jpeg", "image/png", "image/gif"];
        return self::uploadFile($image, "images/uploaded_images/", $supported_files);
    }

    //Sube un video
    public static function uploadVideo(object $video) : array {
        //Primero subo la imagen
        $supported_files = ["video/mpeg", "video/mp4", "video/ogg", "video/webm", "video/x-ms-wmv"];
        return self::uploadFile($video, "videos/uploaded_videos/", $supported_files);
    }

    //Sube un archivo
    public static function uploadFile(object $file, string $folder, array $supported_files = ["application/zip", "application/x-rar-compressed", "application/octet-stream", "application/x-zip-compressed"]) : array {
        $response = [];
        $originalName = $file->getClientOriginalName();
        $extension = get_image_extension($originalName);
        $newName = str_shuffle(time().random_string(5)).".".$extension;
        $path = public_path()."/media/".$folder;

        if (in_array($file->getMimeType(), $supported_files)) {
            //Ahora si subo la imagen
            $file->move($path, $newName);

            //En caso de que sea imagen la redimensiono
            $image_extensions = ["jpg", "jpeg", "png", "gif"];
            if(in_array($extension, $image_extensions))
                resize_image($path.$newName, 300);

            $response["name"] = $newName;
        }
        else {
            $response["status"] = "false";
            $response["message"] = "Por favor sube una imagen válida";
        }

        return $response;
    }

}


?>