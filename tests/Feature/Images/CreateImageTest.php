<?php

namespace Tests\Feature\Newsletter;

use Tests\TestCase;
use App\Image;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class CreateNewsletterTest extends TestCase
{
    use WithoutMiddleware;

    public function testCreatingImage()
    {
        Storage::fake('uploads');

        $response = $this->json('POST', route('admin.images.store'), [
            'file' => UploadedFile::fake()->image('avatar.jpg'),
            'name' => 'tester',
        ]);

        $response->assertStatus(302);

        $image = Image::first();
        $this->assertNotNull($image->file);

        // Assert the file was stored...
        Storage::disk('uploads')->assertExists($image->file->path);
    }
}
