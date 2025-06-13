<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Objet;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class ImageSeeder extends Seeder
{
    public function run(): void
    {
        // Images par catégorie
        $imagesByCategory = [
            1 => [ // Électronique
                'https://images.unsplash.com/photo-1592286927505-1def25115558?w=800&h=600&fit=crop',
                'https://images.unsplash.com/photo-1598327105666-5b89351aff97?w=800&h=600&fit=crop',
                'https://images.unsplash.com/photo-1592286927505-1def25115558?w=800&h=600&fit=crop',
            ],
            2 => [ // Livres
                'https://images.unsplash.com/photo-1544947950-fa07a98d237f?w=800&h=600&fit=crop',
                'https://images.unsplash.com/photo-1541963463532-d68292c34b19?w=800&h=600&fit=crop',
                'https://images.unsplash.com/photo-1544947950-fa07a98d237f?w=800&h=600&fit=crop',
            ],
            3 => [ // Vêtements
                'https://images.unsplash.com/photo-1551488831-00ddcb6c6bd3?w=800&h=600&fit=crop',
                'https://images.unsplash.com/photo-1551488831-00ddcb6c6bd3?w=800&h=600&fit=crop',
                'https://images.unsplash.com/photo-1551488831-00ddcb6c6bd3?w=800&h=600&fit=crop',
            ],
            4 => [ // Sport
                'https://images.unsplash.com/photo-1575311373937-040b8e1fd5b6?w=800&h=600&fit=crop',
                'https://images.unsplash.com/photo-1575311373937-040b8e1fd5b6?w=800&h=600&fit=crop',
                'https://images.unsplash.com/photo-1575311373937-040b8e1fd5b6?w=800&h=600&fit=crop',
            ],
            5 => [ // Maison
                'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?w=800&h=600&fit=crop',
                'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?w=800&h=600&fit=crop',
                'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?w=800&h=600&fit=crop',
            ],
            6 => [ // Jouets
                'https://images.unsplash.com/photo-1566576912321-d58ddd7a6088?w=800&h=600&fit=crop',
                'https://images.unsplash.com/photo-1566576912321-d58ddd7a6088?w=800&h=600&fit=crop',
                'https://images.unsplash.com/photo-1566576912321-d58ddd7a6088?w=800&h=600&fit=crop',
            ],
            7 => [ // Musique
                'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?w=800&h=600&fit=crop',
                'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?w=800&h=600&fit=crop',
                'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?w=800&h=600&fit=crop',
            ],
            8 => [ // Art
                'https://images.unsplash.com/photo-1579783902614-a3fb3927b6a5?w=800&h=600&fit=crop',
                'https://images.unsplash.com/photo-1579783902614-a3fb3927b6a5?w=800&h=600&fit=crop',
                'https://images.unsplash.com/photo-1579783902614-a3fb3927b6a5?w=800&h=600&fit=crop',
            ],
        ];

        // Créer le dossier pour les images s'il n'existe pas
        if (!Storage::exists('public/objets')) {
            Storage::makeDirectory('public/objets');
        }

        // Pour chaque objet dans la base de données
        $objets = Objet::all();
        foreach ($objets as $objet) {
            // Sélectionner une image aléatoire pour la catégorie
            $categoryImages = $imagesByCategory[$objet->category_id] ?? $imagesByCategory[1];
            $imageUrl = $categoryImages[array_rand($categoryImages)];

            // Télécharger l'image
            $response = Http::get($imageUrl);
            if ($response->successful()) {
                // Générer un nom de fichier unique
                $filename = 'objets/' . uniqid() . '.jpg';
                
                // Sauvegarder l'image
                Storage::put('public/' . $filename, $response->body());
                
                // Mettre à jour l'objet avec le chemin de l'image
                $objet->update([
                    'photo' => '/storage/' . $filename
                ]);
            }
        }
    }
} 