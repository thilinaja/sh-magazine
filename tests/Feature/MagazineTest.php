<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Magazine;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MagazineTest extends TestCase
{
    use RefreshDatabase;

    public function test_magazines_can_be_created()
    {
        $pdf = UploadedFile::fake()->create('document.pdf', 100);
        $thumbnail = UploadedFile::fake()->image('avatar.jpg');

        $this->post('/magazines', [
            'name' => 'name',
            'summary' => 'summary',
            'pdf' => $pdf,
            'thumbnail' => $thumbnail,
        ]);

        $this->assertDatabaseHas('magazines', [
            'name' => 'name',
        ]);
    }

    public function test_magazines_can_be_updated()
    {
        $name = 'NewName';
        $magazine = Magazine::factory()->create();
        $this->put('/magazines/'.$magazine->id, [
            'name' => $name,
            'summary' => 'summary',
        ]);

        $this->assertEquals($name, $magazine->fresh()->name);
    }

    public function test_magazines_can_be_deleted()
    {
        $magazine = Magazine::factory()->create();
        $this->delete('/magazines/'.$magazine->id);

        $this->assertDatabaseMissing('magazines', [
            'id' => $magazine->id,
        ]);
    }
}
