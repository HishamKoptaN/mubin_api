<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait ImageUploader
{
    /**
     * وظيفة لرفع الصورة وتخزينها داخل storage
     *
     * @param UploadedFile $image
     * @param string $folder
     * @return string $path
     */
    public function uploadImageToStorage(UploadedFile $image, string $folder)
    {
        // إنشاء اسم فريد للصورة
        $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

        // تحديد المسار داخل مجلد storage
        $folderPath = trim($folder, '/');
        $path = $folderPath . '/' . $imageName;

        // نقل الصورة إلى المجلد داخل storage
        Storage::put($path, file_get_contents($image->getRealPath()));

        // إرجاع المسار
        return $path;
    }
}
