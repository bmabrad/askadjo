<?php

use App\Livewire\CoachInput;
use App\Models\Contact;
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

it('renders the component', function () {
    Livewire::test(CoachInput::class)
        ->assertOk();
});

it('can switch input modes', function () {
    Livewire::test(CoachInput::class)
        ->assertSet('inputMode', 'screenshot')
        ->call('switchMode', 'text')
        ->assertSet('inputMode', 'text')
        ->call('switchMode', 'screenshot')
        ->assertSet('inputMode', 'screenshot');
});

it('can upload a screenshot', function () {
    Livewire::test(CoachInput::class)
        ->set('screenshots', [UploadedFile::fake()->image('chat.jpg', 400, 800)])
        ->assertHasNoErrors('screenshots.*');
});

it('rejects non-image file', function () {
    Livewire::test(CoachInput::class)
        ->set('screenshots', [UploadedFile::fake()->create('document.pdf', 100, 'application/pdf')])
        ->assertHasErrors(['screenshots.0']);
});

it('rejects oversized image', function () {
    Livewire::test(CoachInput::class)
        ->set('screenshots', [UploadedFile::fake()->image('huge.jpg')->size(6000)])
        ->assertHasErrors('screenshots.*');
});

it('enforces max four screenshots', function () {
    Livewire::test(CoachInput::class)
        ->set('contactId', $this->contact->id)
        ->set('screenshots', [
            UploadedFile::fake()->image('a.jpg'),
            UploadedFile::fake()->image('b.jpg'),
            UploadedFile::fake()->image('c.jpg'),
            UploadedFile::fake()->image('d.jpg'),
            UploadedFile::fake()->image('e.jpg'),
        ])
        ->call('submit')
        ->assertHasErrors('screenshots');
});

it('can remove a screenshot', function () {
    $component = Livewire::test(CoachInput::class)
        ->set('screenshots', [
            UploadedFile::fake()->image('a.jpg'),
            UploadedFile::fake()->image('b.jpg'),
        ]);

    $component->call('removeScreenshot', 0);

    expect($component->get('screenshots'))->toHaveCount(1);
});

it('requires a contact to submit', function () {
    Livewire::test(CoachInput::class)
        ->set('inputMode', 'text')
        ->set('textInput', 'Her: Hey\nMe: Hello')
        ->call('submit')
        ->assertHasErrors('contactId');
});

it('requires input to submit', function () {
    Livewire::test(CoachInput::class)
        ->set('contactId', $this->contact->id)
        ->set('inputMode', 'text')
        ->set('textInput', '')
        ->call('submit')
        ->assertHasErrors('textInput');
});

it('submits with text and calls coaching service', function () {
    Livewire::test(CoachInput::class)
        ->set('contactId', $this->contact->id)
        ->set('inputMode', 'text')
        ->set('textInput', 'Her: Hey how are you?\nMe: Good, you?')
        ->call('submit')
        ->assertHasNoErrors()
        ->assertDispatched('coaching-session-created');

    $this->assertDatabaseHas('coaching_sessions', [
        'contact_id' => $this->contact->id,
        'input_type' => 'text',
    ]);
});

it('submits with screenshots and calls coaching service', function () {
    Livewire::test(CoachInput::class)
        ->set('contactId', $this->contact->id)
        ->set('inputMode', 'screenshot')
        ->set('screenshots', [UploadedFile::fake()->image('chat.jpg', 400, 800)])
        ->call('submit')
        ->assertHasNoErrors()
        ->assertDispatched('coaching-session-created');

    $this->assertDatabaseHas('coaching_sessions', [
        'contact_id' => $this->contact->id,
        'input_type' => 'screenshot',
    ]);
});

it('emits session-created with session id on success', function () {
    Livewire::test(CoachInput::class)
        ->set('contactId', $this->contact->id)
        ->set('inputMode', 'text')
        ->set('textInput', 'Her: Hey\nMe: Hello')
        ->call('submit')
        ->assertDispatched('coaching-session-created', function ($event, $params) {
            return isset($params['sessionId']) && is_int($params['sessionId']);
        });
});

it('shows error on failure', function () {
    $mock = Mockery::mock(\App\Services\CoachingService::class);
    $mock->shouldReceive('coach')->andThrow(new \RuntimeException('Something broke'));
    app()->instance(\App\Services\CoachingService::class, $mock);

    Livewire::test(CoachInput::class)
        ->set('contactId', $this->contact->id)
        ->set('inputMode', 'text')
        ->set('textInput', 'Her: Hey\nMe: Hello')
        ->call('submit')
        ->assertSet('error', 'Something went wrong. Try a cleaner screenshot or paste the text instead.');
});

it('locks contact when preset via mount', function () {
    Livewire::test(CoachInput::class, ['contactId' => $this->contact->id])
        ->assertSet('contactId', $this->contact->id)
        ->assertSet('contactLocked', true);
});
