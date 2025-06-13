<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Objet;
use App\Models\Troc;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Création des catégories
        $categories = [
            ['name' => 'Électronique', 'icon' => '📱'],
            ['name' => 'Livres', 'icon' => '📚'],
            ['name' => 'Vêtements', 'icon' => '👕'],
            ['name' => 'Sport', 'icon' => '⚽'],
            ['name' => 'Maison', 'icon' => '🏠'],
            ['name' => 'Jouets', 'icon' => '🎮'],
            ['name' => 'Musique', 'icon' => '🎵'],
            ['name' => 'Art', 'icon' => '🎨'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Création des utilisateurs de test
        $users = [
            [
                'name' => 'Marie Martin',
                'email' => 'marie@example.com',
                'password' => Hash::make('password'),
                'role' => 'membre',
                'created_at' => Carbon::now()->subMonths(3),
            ],
            [
                'name' => 'Pierre Dubois',
                'email' => 'pierre@example.com',
                'password' => Hash::make('password'),
                'role' => 'membre',
                'created_at' => Carbon::now()->subMonths(2),
            ],
            [
                'name' => 'Sophie Bernard',
                'email' => 'sophie@example.com',
                'password' => Hash::make('password'),
                'role' => 'membre',
                'created_at' => Carbon::now()->subMonths(1),
            ],
        ];

        foreach ($users as $userData) {
            User::create($userData);
        }

        // Création des objets
        $objets = [
            // Marie Martin
            [
                'title' => 'iPhone 12 Pro',
                'description' => 'iPhone 12 Pro en excellent état, boîte et accessoires inclus.',
                'category_id' => 1,
                'user_id' => 1,
                'status' => 'disponible',
                'created_at' => Carbon::now()->subDays(30),
            ],
            [
                'title' => 'Collection Harry Potter',
                'description' => 'Série complète des livres Harry Potter en français.',
                'category_id' => 2,
                'user_id' => 1,
                'status' => 'disponible',
                'created_at' => Carbon::now()->subDays(25),
            ],
            [
                'title' => 'Vélo de course',
                'description' => 'Vélo de course Trek en bon état, peu utilisé.',
                'category_id' => 4,
                'user_id' => 1,
                'status' => 'disponible',
                'created_at' => Carbon::now()->subDays(20),
            ],

            // Pierre Dubois
            [
                'title' => 'PS5',
                'description' => 'PlayStation 5 avec 2 manettes et 3 jeux.',
                'category_id' => 6,
                'user_id' => 2,
                'status' => 'disponible',
                'created_at' => Carbon::now()->subDays(28),
            ],
            [
                'title' => 'Tableau moderne',
                'description' => 'Tableau abstrait contemporain, 80x60cm.',
                'category_id' => 8,
                'user_id' => 2,
                'status' => 'disponible',
                'created_at' => Carbon::now()->subDays(22),
            ],
            [
                'title' => 'Guitare électrique',
                'description' => 'Guitare électrique Fender Stratocaster, avec ampli.',
                'category_id' => 7,
                'user_id' => 2,
                'status' => 'disponible',
                'created_at' => Carbon::now()->subDays(15),
            ],

            // Sophie Bernard
            [
                'title' => 'Canapé d\'angle',
                'description' => 'Canapé d\'angle en cuir, 3 places, excellent état.',
                'category_id' => 5,
                'user_id' => 3,
                'status' => 'disponible',
                'created_at' => Carbon::now()->subDays(18),
            ],
            [
                'title' => 'Collection de vinyles',
                'description' => 'Collection de vinyles rock des années 70-80.',
                'category_id' => 7,
                'user_id' => 3,
                'status' => 'disponible',
                'created_at' => Carbon::now()->subDays(12),
            ],
            [
                'title' => 'Manteau d\'hiver',
                'description' => 'Manteau d\'hiver The North Face, taille M.',
                'category_id' => 3,
                'user_id' => 3,
                'status' => 'disponible',
                'created_at' => Carbon::now()->subDays(8),
            ],
        ];

        foreach ($objets as $objet) {
            Objet::create($objet);
        }

        // Création des trocs
        $trocs = [
            // Troc entre Marie et Pierre
            [
                'objet_offert_id' => 1, // iPhone de Marie
                'objet_demande_id' => 4, // PS5 de Pierre
                'user_propose_id' => 1, // Marie propose
                'user_cible_id' => 2, // à Pierre
                'status' => 'en_attente',
                'created_at' => Carbon::now()->subDays(5),
            ],
            // Troc entre Pierre et Sophie
            [
                'objet_offert_id' => 5, // Tableau de Pierre
                'objet_demande_id' => 7, // Canapé de Sophie
                'user_propose_id' => 2, // Pierre propose
                'user_cible_id' => 3, // à Sophie
                'status' => 'accepté',
                'created_at' => Carbon::now()->subDays(10),
            ],
            // Troc entre Sophie et Marie
            [
                'objet_offert_id' => 8, // Vinyles de Sophie
                'objet_demande_id' => 2, // Harry Potter de Marie
                'user_propose_id' => 3, // Sophie propose
                'user_cible_id' => 1, // à Marie
                'status' => 'refusé',
                'created_at' => Carbon::now()->subDays(15),
            ],
            // Troc entre Marie et Sophie
            [
                'objet_offert_id' => 3, // Vélo de Marie
                'objet_demande_id' => 9, // Manteau de Sophie
                'user_propose_id' => 1, // Marie propose
                'user_cible_id' => 3, // à Sophie
                'status' => 'en_attente',
                'created_at' => Carbon::now()->subDays(2),
            ],
        ];

        foreach ($trocs as $troc) {
            Troc::create($troc);
        }

        // Exécuter le seeder d'images
        $this->call(ImageSeeder::class);
    }
}
