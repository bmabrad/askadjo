<?php

namespace Database\Factories;

use App\Enums\ContactStatus;
use App\Enums\Platform;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Contact>
 */
class ContactFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'name' => fake()->firstName(),
            'platform' => fake()->randomElement(Platform::cases()),
            'status' => ContactStatus::Active,
            'notes' => null,
        ];
    }

    public function archived(): static
    {
        return $this->state(['status' => ContactStatus::Archived]);
    }
}
