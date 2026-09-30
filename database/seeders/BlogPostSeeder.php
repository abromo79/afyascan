<?php

namespace Database\Seeders;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Migrates the blog articles that were previously hard-coded in the blog page
 * into the database, so the public blog keeps showing the same content.
 */
class BlogPostSeeder extends Seeder
{
    public function run(): void
    {
        $author = User::where('role', User::ROLE_ADMIN)->first();

        $posts = [
            [
                'category' => 'Breast Health',
                'title' => 'Understanding Breast Health Awareness',
                'excerpt' => 'Learn why breast health awareness is important and how technology can support better health education.',
                'image' => 'gallery-1.webp',
                'content' => '<p>Breast health awareness is one of the simplest and most effective ways of supporting early detection. Knowing what is normal, understanding personal risk factors, and knowing when to seek advice all contribute to better outcomes.</p><h3>Why awareness matters</h3><p>Many changes in breast health are noticed first by the people experiencing them. Regular awareness helps people describe those changes accurately and seek professional advice earlier.</p><h3>Where technology helps</h3><p>Digital tools can make health information easier to access and easier to understand. At AfyaScan we believe technology should support health education, not replace professional medical advice.</p>',
            ],
            [
                'category' => 'AI & Healthcare',
                'title' => 'Artificial Intelligence in Healthcare',
                'excerpt' => 'Explore how artificial intelligence is creating new possibilities in modern digital healthcare.',
                'image' => 'gallery-2.webp',
                'content' => '<p>Artificial intelligence is moving from research settings into everyday healthcare workflows. The most useful applications are often the least dramatic: reducing repetitive work, highlighting patterns, and making information easier to act on.</p><h3>Practical applications</h3><p>Common examples include image review support, structured data extraction, and patient education tools. Each of these works best when a qualified professional remains in control of decisions.</p><h3>A responsible approach</h3><p>AI in healthcare must be transparent about its limits, evaluated carefully, and deployed in ways that genuinely help people rather than simply automating them.</p>',
            ],
            [
                'category' => 'Health Technology',
                'title' => 'AI Medical Image Analysis',
                'excerpt' => 'Discover how AI-powered image analysis can support healthcare professionals in reviewing medical images.',
                'image' => 'gallery-3.webp',
                'content' => '<p>Medical imaging produces large volumes of data that are time-consuming to review. Image analysis tools are being developed to help professionals prioritise, annotate, and cross-check findings.</p><h3>Supporting, not replacing</h3><p>These tools are designed to support clinical decision-making, not to make diagnoses on their own. A qualified healthcare professional always remains responsible for the final assessment.</p><h3>Breast imaging in focus</h3><p>Breast-related imaging is an important area of focus for AfyaScan, with the aim of improving review consistency and reducing delays in reporting.</p>',
            ],
            [
                'category' => 'Risk Assessment',
                'title' => 'Digital Health Risk Assessment',
                'excerpt' => 'Understand how digital tools can organize health information to support awareness and informed action.',
                'image' => 'gallery-4.webp',
                'content' => '<p>A risk assessment is most useful when it collects the right information, organises it clearly, and helps a person understand which next steps matter. Digital tools make that process repeatable and easier to follow.</p><h3>What a good assessment does</h3><ul><li>Collects relevant information consistently</li><li>Presents findings in plain language</li><li>Highlights what deserves attention first</li><li>Encourages professional consultation where needed</li></ul><p>AfyaScan is developing an AI-assisted risk assessment product for breast health awareness.</p>',
            ],
            [
                'category' => 'Responsible AI',
                'title' => 'Responsible AI in Healthcare',
                'excerpt' => 'Explore the importance of responsible, transparent and human-centered artificial intelligence in healthcare.',
                'image' => 'gallery-5.webp',
                'content' => '<p>Healthcare decisions affect people directly, which raises the bar for any technology involved. Responsible AI in healthcare means being clear about what a system can and cannot do.</p><h3>Our principles</h3><ul><li><strong>Transparency:</strong> people should know when AI is involved.</li><li><strong>Human control:</strong> qualified professionals make the decisions.</li><li><strong>Accessibility:</strong> solutions should be usable by the people who need them.</li><li><strong>Evaluation:</strong> performance and limitations should be measured openly.</li></ul><p>These principles guide how AfyaScan builds and evaluates its products.</p>',
            ],
            [
                'category' => 'Digital Health',
                'title' => 'Technology for Better Breast Health',
                'excerpt' => 'Learn how digital innovation can contribute to improved breast health awareness and access to information.',
                'image' => 'gallery-6.webp',
                'content' => '<p>Breast health improves when the right information reaches the right person at the right time. Digital products can shorten the distance between general knowledge and personal understanding.</p><h3>Awareness and access</h3><p>Clear, plain-language education helps people recognise what to pay attention to. Accessible tools help people act on that knowledge without needing specialised equipment or expensive services.</p><h3>Our focus</h3><p>AfyaScan is a health technology startup focused on breast health, developing AI-powered products that support awareness, risk assessment, and medical image analysis.</p>',
            ],
            [
                'category' => 'Innovation',
                'title' => 'Digital Innovation in Healthcare',
                'excerpt' => 'Explore the role of digital technologies in building more accessible and connected healthcare solutions.',
                'image' => 'gallery-7.webp',
                'content' => '<p>Digital innovation in healthcare is not only about new technology. It is about removing barriers: making services easier to reach, easier to understand, and easier to continue using.</p><h3>Connected care</h3><p>When information flows more smoothly between people and services, care becomes more continuous. Digital tools help by keeping people connected to guidance between appointments.</p><h3>Building responsibly</h3><p>Innovation only matters when it improves outcomes for the people it is designed to serve.</p>',
            ],
            [
                'category' => 'AfyaScan',
                'title' => 'AfyaScan Health Technology Innovation',
                'excerpt' => "Follow AfyaScan's journey in developing AI-powered solutions for breast health awareness and innovation.",
                'image' => 'gallery-8.webp',
                'content' => '<p>AfyaScan is a health technology startup developing responsible, accessible and AI-powered solutions for breast health. This blog shares what we are learning as the products take shape.</p><h3>What we are building</h3><ul><li><strong>Risk Assessment:</strong> an AI-assisted tool to help users understand relevant risk factors.</li><li><strong>AI Image Analysis:</strong> an AI-assisted solution to support the evaluation of breast-related medical images.</li></ul><h3>Working with others</h3><p>We collaborate with healthcare, research, technology, and innovation partners who share our focus on responsible AI. If you are interested in working together, please get in touch.</p>',
            ],
        ];

        $publishedAt = now()->subMonths(8);

        foreach ($posts as $index => $post) {
            $category = BlogCategory::firstOrCreate(
                ['name' => $post['category']],
                ['slug' => Str::slug($post['category'])],
            );

            BlogPost::updateOrCreate(
                ['slug' => Str::slug($post['title'])],
                [
                    'blog_category_id' => $category->id,
                    'user_id' => $author?->id,
                    'title' => $post['title'],
                    'excerpt' => $post['excerpt'],
                    'content' => $post['content'],
                    'featured_image' => $this->importImage($post['image']),
                    'status' => BlogPost::STATUS_PUBLISHED,
                    'published_at' => $publishedAt->copy()->addDays($index * 10),
                ]
            );
        }
    }

    /**
     * Copy one of the existing site images into the public disk so the post
     * behaves exactly like a post with an uploaded featured image.
     */
    private function importImage(string $filename): ?string
    {
        $source = public_path('assets/img/gallery/'.$filename);

        if (! is_file($source)) {
            return null;
        }

        $target = 'blog/'.$filename;

        if (! Storage::disk('public')->exists($target)) {
            Storage::disk('public')->put($target, file_get_contents($source));
        }

        return $target;
    }
}
