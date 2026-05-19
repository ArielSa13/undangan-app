<?php

namespace Database\Seeders;

use App\Models\Template;
use Illuminate\Database\Seeder;

class TemplateSeeder extends Seeder
{
    public function run(): void
    {
        $templates = [
            [
                'name' => 'Elegant Gold',
                'slug' => 'elegant-gold',
                'description' => 'Template elegan dengan aksen emas yang mewah dan klasik.',
                'category' => 'elegant',
                'tier' => 'basic',
                'blade_path' => 'elegant-gold',
                'is_active' => true,
                'is_premium' => false,
                'sort_order' => 1,
                'color_scheme' => [
                    'primary' => '#D4AF37',
                    'secondary' => '#1a1a2e',
                    'background' => '#fefefe',
                    'text' => '#333333',
                ],
                'fonts' => [
                    'heading' => 'Playfair Display',
                    'body' => 'Lato',
                ],
            ],
            [
                'name' => 'Minimal White',
                'slug' => 'minimal-white',
                'description' => 'Template minimalis dengan nuansa putih bersih dan modern.',
                'category' => 'minimal',
                'tier' => 'basic',
                'blade_path' => 'minimal-white',
                'is_active' => true,
                'is_premium' => false,
                'sort_order' => 2,
                'color_scheme' => [
                    'primary' => '#6B7280',
                    'secondary' => '#F3F4F6',
                    'background' => '#FFFFFF',
                    'text' => '#1F2937',
                ],
                'fonts' => [
                    'heading' => 'Cormorant Garamond',
                    'body' => 'Inter',
                ],
            ],
            [
                'name' => 'Luxury Black',
                'slug' => 'luxury-black',
                'description' => 'Template mewah dengan tema gelap yang sophisticated.',
                'category' => 'luxury',
                'tier' => 'premium',
                'blade_path' => 'luxury-black',
                'is_active' => true,
                'is_premium' => true,
                'sort_order' => 3,
                'color_scheme' => [
                    'primary' => '#C9A96E',
                    'secondary' => '#2D2D2D',
                    'background' => '#1A1A1A',
                    'text' => '#FFFFFF',
                ],
                'fonts' => [
                    'heading' => 'Cinzel',
                    'body' => 'Raleway',
                ],
            ],
            [
                'name' => 'Floral Romantic',
                'slug' => 'floral-romantic',
                'description' => 'Template romantis dengan ornamen bunga yang indah.',
                'category' => 'romantic',
                'tier' => 'premium',
                'blade_path' => 'floral-romantic',
                'is_active' => true,
                'is_premium' => true,
                'sort_order' => 4,
                'color_scheme' => [
                    'primary' => '#E8A0BF',
                    'secondary' => '#BA90C6',
                    'background' => '#FFF8F0',
                    'text' => '#4A3728',
                ],
                'fonts' => [
                    'heading' => 'Great Vibes',
                    'body' => 'Montserrat',
                ],
            ],
            [
                'name' => 'Islamic Elegant',
                'slug' => 'islamic-elegant',
                'description' => 'Template elegan dengan ornamen Islami yang indah dan sopan.',
                'category' => 'islamic',
                'tier' => 'premium',
                'blade_path' => 'islamic-elegant',
                'is_active' => true,
                'is_premium' => true,
                'sort_order' => 5,
                'color_scheme' => [
                    'primary' => '#1B5E20',
                    'secondary' => '#C8A415',
                    'background' => '#FFFDF7',
                    'text' => '#2C3E50',
                ],
                'fonts' => [
                    'heading' => 'Amiri',
                    'body' => 'Poppins',
                ],
            ],
        ];

        foreach ($templates as $template) {
            Template::create($template);
        }
    }
}
