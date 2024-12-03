<?php
if (!function_exists('uploadImage')) {
    /**
     * To upload image to the specified directory and return the image URL.
     *
     * @param \Illuminate\Http\UploadedFile $image
     * @param string $directory
     * @return string
     */
    function uploadImage(
        $image,
        $directory,
    ) {
        // تحقق من امتداد الصورة
        $imageName = time() . '.' . $image->getClientOriginalExtension();

        // تحميل الصورة إلى المجلد المحدد
        $image->move(public_path('storage/' . $directory), $imageName);

        // إعادة رابط الصورة
        return asset('public/' . 'storage/' . $directory . '/' . $imageName);
    }
}
