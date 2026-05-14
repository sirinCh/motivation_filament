<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Quote;
use Illuminate\Database\Seeder;

class QuoteSeeder extends Seeder
{
    public function run(): void
    {
        $quotes = [
            ['text' => "Le succès c'est d'aller d'échec en échec sans perdre son enthousiasme.", 'author' => 'Winston Churchill'],
            ['text' => "La seule façon de faire du bon travail est d'aimer ce que vous faites.", 'author' => 'Steve Jobs'],
            ['text' => 'Le meilleur moyen de prédire le futur est de le créer.', 'author' => 'Peter Drucker'],
            ['text' => "Ce n'est pas parce que les choses sont difficiles que nous ne devons pas les faire.", 'author' => 'John F. Kennedy'],
            ['text' => 'La discipline est le pont entre les objectifs et les réalisations.', 'author' => 'Jim Rohn'],
            ['text' => 'Chaque jour est une nouvelle chance de changer votre vie.', 'author' => 'Inconnu'],
            ['text' => "Votre temps est limité, ne le gaspillez pas à vivre la vie de quelqu'un d'autre.", 'author' => 'Steve Jobs'],
            ['text' => "Le courage n'est pas l'absence de peur, mais la capacité d'agir malgré la peur.", 'author' => 'Nelson Mandela'],
            ['text' => 'Les grands résultats nécessitent de grandes ambitions.', 'author' => 'Héraclite'],
            ['text' => "La persévérance n'est pas une longue course, c'est beaucoup de petites courses l'une après l'autre.", 'author' => 'Walter Elliot'],
        ];

        foreach ($quotes as $quote) {
            Quote::create($quote);
        }
    }
}
