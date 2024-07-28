<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ShotUpload>
 */
class ShotUploadFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $url = "https://picsum.photos/seed/". fake()->uuid() ."/500/300";
        $info = pathinfo($url);
        $contents = file_get_contents($url);
        $path = '/tmp/' . $info['basename'];
        file_put_contents($path, $contents);
        $image = (new UploadedFile($path, $info['basename']))->storePublicly('uploads');
        $info = getimagesize(Storage::path($image));

        return [
            'path' => $image,
            "size_in_bytes" => Storage::fileSize($image),
            "resolution" => $info[0] . "x" . $info[1] . "px",
            "format" => $info["mime"],
        ];
    }
}
