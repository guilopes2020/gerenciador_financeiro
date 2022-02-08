<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Outgoing;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class EntriesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        /*return [
            'id_user' => User::pluck('id')->random(),
            'category' => ['casa', 'alugueis', 'freelas', 'outros'],
            'created' => now(),
            'description' => $this->faker->text(nbSentences: 1),
            'value' => $this->faker->floatval(random(10, 1500)),
            'paga' => $this->faker->integer(0),
            'vencimento' => $this->faker->random(now(), $date('2025-10-01'))
        ];*/
    }
}
