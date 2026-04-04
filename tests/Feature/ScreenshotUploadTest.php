<?php

use App\Livewire\CoachInput;
use App\Models\Contact;
use App\Models\CoachingSession;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
    $this->contact = Contact::factory()->create(['user_id' => $this->user->id]);

    Storage::fake('screenshots');
});

it('stores screenshots on the correct disk', function () {
    Livewire::test(CoachInput::class)
        ->set('contactId', $this->contact->id)
        ->set('inputMode', 'screenshot')
        ->set('screenshots', [UploadedFile::fake()->image('chat.jpg', 400, 800)])
        ->call('submit');

    $files = Storage::disk('screenshots')->allFiles();
    expect($files)->toHaveCount(1);
});

it('saves screenshot paths to the coaching session', function () {
    Livewire::test(CoachInput::class)
        ->set('contactId', $this->contact->id)
        ->set('inputMode', 'screenshot')
        ->set('screenshots', [
            UploadedFile::fake()->image('chat1.jpg', 400, 800),
            UploadedFile::fake()->image('chat2.jpg', 400, 800),
        ])
        ->call('submit');

    $session = CoachingSession::where('contact_id', $this->contact->id)->first();
    expect($session->screenshot_path)->toBeArray()->toHaveCount(2);
});
