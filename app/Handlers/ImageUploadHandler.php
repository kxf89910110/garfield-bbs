<?php

namespace App\Handlers;

use Image;

class ImageUploadHandler
{
    // Only image files with the following suffixes are allowed to be uploaded
    protected $allowed_ext = ["png", "jpg", "gif", "jpeg"];

    public function save($file, $folder, $file_prefix, $max_width = false)
    {
        // Build a stored folder rule with values such as:uploads/images/avatars/201709/21/
        // Folder cutting can make searching more efficient.
        $folder_name = "uploads/images/$folder/" . date("Ym/d", time());

        // The physical path of the file storage, 'public_path()' gets the physical path of the 'public' folder
        // Values such as:/home/vagrant/Code/larabbs/public/uploads/images/avatars/201709/21/
        $upload_path = public_path() . '/' . $folder_name;

        // Get the suffix name of the file, because the suffix is empty when the image is pasted from the clipboard, so make sure the suffix always exists here.
        $extension = strtolower($file->getClientOriginalExtension()) ?: 'png';

        // The name of the splicing file, prefixed to increase the degree of resolution, the prefix can be the ID of the relevant data model
        // Values such as:1_1493521050_7BVc9v9ujP.png
        $filename = $file_prefix . '_' . time() . '_' . str_random(10) . '.' . $extension;

        // If the upload is not an image, the operation will be terminated.
        if ( ! in_array($extension, $this->allowed_ext)) {
            return false;
        }

        // Move the image to our target storage path
        $file->move($upload_path, $filename);

        // Crop if the image width is limited
        if ($max_width && $extension != 'gif') {

            // A function encapsulated in this class that is used to crop the image
            $this->reduceSize($upload_path . '/' . $filename, $max_width);
        }

        return [
            'path' => config('app.url') . "/$folder_name/$filename"
        ];
    }

    public function reduceSize($file_path, $max_width)
    {
        // First instantiate, the parameter is the disk physical path of the file
        $image = Image::make($file_path);

        // Sizing operations
        $image->resize($max_width, null, function ($constraint) {

            // Set the width to $max_with, the height is proportional to both sides of the zoom
            $constraint->aspectRatio();

            // Prevent image size from getting larger when cropping
            $constraint->upsize();
        });

        // Save the image after editing
        $image->save();
    }
}
