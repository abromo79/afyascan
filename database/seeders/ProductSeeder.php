<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'slug' => 'risk-assessment',
                'name' => 'Risk Assessment',
                'label' => 'AI Health Assessment',
                'short_description' => 'An AI-assisted breast health risk assessment product designed to help users understand relevant risk factors and improve awareness of breast health.',
                'description' => 'An AI-assisted breast health risk assessment tool designed to help individuals understand relevant risk factors and encourage informed health awareness. AfyaScan blends data capture, analytical review and practical reporting so users can move confidently from issue detection to action planning.',
                'features' => "AI-Assisted Assessment\nBreast Health Awareness\nRisk Factor Assessment",
                'icon' => 'fas fa-heartbeat',
                'is_published' => true,
                'display_order' => 1,
            ],
            [
                'slug' => 'ai-image-analysis',
                'name' => 'AI Image Analysis',
                'label' => 'AI Medical Imaging',
                'short_description' => 'An AI-powered medical image analysis product designed to support the analysis of breast-related medical images and assist healthcare professionals in clinical decision-making.',
                'description' => 'An AI-assisted medical image analysis solution being developed to support the evaluation of breast-related images and assist healthcare professionals. The goal is faster interpretation, cleaner annotations and more dependable review processes across imaging workflows.',
                'features' => "AI Image Analysis\nClinical Decision Support",
                'icon' => 'fas fa-brain',
                'is_published' => true,
                'display_order' => 2,
            ],
        ];

        foreach ($products as $product) {
            Product::updateOrCreate(['slug' => $product['slug']], $product);
        }
    }
}
