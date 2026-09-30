<?php

namespace Database\Factories;

use App\Models\ContactMessage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ContactMessage>
 */
class ContactMessageFactory extends Factory
{
    protected $model = ContactMessage::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'organization' => fake()->company(),
            'subject' => fake()->sentence(4),
            'message' => fake()->paragraph(),
            'is_read' => false,
            'is_replied' => false,
            'is_archived' => false,
        ];
    }

    public function read(): static
    {
        return $this->state(fn () => ['is_read' => true]);
    }

    public function archived(): static
    {
        return $this->state(fn () => ['is_archived' => true]);
    }
}
