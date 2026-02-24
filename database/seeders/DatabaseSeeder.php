<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\CourseCompletion;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\LessonProgress;
use App\Models\Level;
use App\Models\User;
use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Users ──────────────────────────────────────────────────
        $admin = User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'is_admin' => true,
            ]
        );

        $regularUser = User::updateOrCreate(
            ['email' => 'user@gmail.com'],
            [
                'name' => 'Jane Learner',
                'password' => Hash::make('password'),
                'is_admin' => false,
            ]
        );

        // ── Levels ─────────────────────────────────────────────────
        $levels = [
            ['name' => 'Beginner',     'slug' => 'beginner'],
            ['name' => 'Intermediate', 'slug' => 'intermediate'],
            ['name' => 'Advanced',     'slug' => 'advanced'],
        ];

        $levelModels = [];
        foreach ($levels as $lvl) {
            $levelModels[$lvl['slug']] = Level::firstOrCreate(['slug' => $lvl['slug']], ['name' => $lvl['name']]);
        }

        // courses & lessons ──────────────────────────────────────
        Enrollment::query()->delete();
        LessonProgress::query()->delete();
        CourseCompletion::query()->delete();
        Lesson::query()->forceDelete();
        Course::query()->forceDelete();

        $courses = [
            [
                'level' => 'beginner',
                'title' => 'Web Development Fundamentals',
                'description' => 'Master the core building blocks of the web — HTML, CSS, and JavaScript. Build your first websites from scratch with hands-on projects.',
                'image_url' => 'https://images.unsplash.com/photo-1547658719-da2b51169166?w=800&h=600&fit=crop',
                'is_published' => true,
                'lessons' => [
                    ['title' => 'Introduction to HTML', 'video_url' => 'https://www.youtube.com/watch?v=qz0aGYrrlhU', 'duration_seconds' => 340, 'is_free_preview' => true],
                    ['title' => 'CSS Styling Basics',   'video_url' => 'https://www.youtube.com/watch?v=yfoY53QXEnI', 'duration_seconds' => 420, 'is_free_preview' => true],
                    ['title' => 'Flexbox & Grid',       'video_url' => 'https://www.youtube.com/watch?v=K74l26pE4YA', 'duration_seconds' => 560, 'is_free_preview' => false],
                    ['title' => 'JavaScript Essentials', 'video_url' => 'https://www.youtube.com/watch?v=W6NZfCO5SIk', 'duration_seconds' => 720, 'is_free_preview' => false],
                    ['title' => 'DOM Manipulation',     'video_url' => 'https://www.youtube.com/watch?v=0ik6X4DJKCc', 'duration_seconds' => 480, 'is_free_preview' => false],
                ],
            ],
            [
                'level' => 'beginner',
                'title' => 'Git & GitHub for Beginners',
                'description' => 'Learn version control with Git and collaborate on projects using GitHub. An essential skill for every developer.',
                'image_url' => 'https://images.unsplash.com/photo-1618401471353-b98afee0b2eb?w=800&h=600&fit=crop',
                'is_published' => true,
                'lessons' => [
                    ['title' => 'What is Version Control?', 'video_url' => 'https://www.youtube.com/watch?v=9GKpbI1siow', 'duration_seconds' => 300, 'is_free_preview' => true],
                    ['title' => 'Git Init & Commits',       'video_url' => 'https://www.youtube.com/watch?v=SWYqp7iY_Tc', 'duration_seconds' => 400, 'is_free_preview' => true],
                    ['title' => 'Branches & Merging',       'video_url' => 'https://www.youtube.com/watch?v=Q1kHG842HoI', 'duration_seconds' => 500, 'is_free_preview' => false],
                    ['title' => 'Working with GitHub',      'video_url' => 'https://www.youtube.com/watch?v=nhNq2kIvi9s', 'duration_seconds' => 460, 'is_free_preview' => false],
                ],
            ],
            [
                'level' => 'intermediate',
                'title' => 'Laravel 11 Complete Course',
                'description' => 'Build full-stack PHP applications with Laravel 11. From routing to Eloquent ORM, authentication, queues, and testing.',
                'image_url' => 'https://images.unsplash.com/photo-1555099962-4199c345e5dd?w=800&h=600&fit=crop',
                'is_published' => true,
                'lessons' => [
                    ['title' => 'Laravel Installation & MVC', 'video_url' => 'https://www.youtube.com/watch?v=MFh0Fd7BsjE', 'duration_seconds' => 600,  'is_free_preview' => true],
                    ['title' => 'Eloquent ORM Deep Dive',     'video_url' => 'https://www.youtube.com/watch?v=0BSW4MaSRo8', 'duration_seconds' => 720, 'is_free_preview' => true],
                    ['title' => 'Authentication with Breeze', 'video_url' => 'https://www.youtube.com/watch?v=UHSipe7pSac', 'duration_seconds' => 540, 'is_free_preview' => false],
                    ['title' => 'Middleware & Policies',      'video_url' => 'https://www.youtube.com/watch?v=IDeoiFSJlRA', 'duration_seconds' => 480, 'is_free_preview' => false],
                    ['title' => 'Queues & Jobs',              'video_url' => 'https://www.youtube.com/watch?v=rVx8xKisbr8', 'duration_seconds' => 660, 'is_free_preview' => false],
                    ['title' => 'Testing with Pest',          'video_url' => 'https://www.youtube.com/watch?v=lm9jkYYML1c', 'duration_seconds' => 590, 'is_free_preview' => false],
                ],
            ],
            [
                'level' => 'intermediate',
                'title' => 'Vue.js 3 & Composition API',
                'description' => 'Modern front-end development with Vue 3. Learn the Composition API, Pinia for state management, and Vue Router.',
                'image_url' => 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=800&h=600&fit=crop',
                'is_published' => true,
                'lessons' => [
                    ['title' => 'Vue 3 Setup & Options API',  'video_url' => 'https://www.youtube.com/watch?v=qZXt1Aom3Cs', 'duration_seconds' => 500, 'is_free_preview' => true],
                    ['title' => 'Composition API Basics',     'video_url' => 'https://www.youtube.com/watch?v=bwItFdPt-6M', 'duration_seconds' => 620, 'is_free_preview' => false],
                    ['title' => 'State Management with Pinia', 'video_url' => 'https://www.youtube.com/watch?v=JGC7aAC-3y8', 'duration_seconds' => 540, 'is_free_preview' => false],
                    ['title' => 'Vue Router & Navigation',    'video_url' => 'https://www.youtube.com/watch?v=LLT_gMImLyY', 'duration_seconds' => 460, 'is_free_preview' => false],
                    ['title' => 'Real-World Project',         'video_url' => 'https://www.youtube.com/watch?v=e-E0UB-YDRk', 'duration_seconds' => 870, 'is_free_preview' => false],
                ],
            ],
            [
                'level' => 'advanced',
                'title' => 'System Design Masterclass',
                'description' => 'Design scalable, distributed systems like the ones used at top tech companies. Covers caching, load balancing, databases at scale, and microservices.',
                'image_url' => 'https://images.unsplash.com/photo-1558494949-ef010cbdcc31?w=800&h=600&fit=crop',
                'is_published' => true,
                'lessons' => [
                    ['title' => 'What is System Design?',      'video_url' => 'https://www.youtube.com/watch?v=i53Gi_K3o7I', 'duration_seconds' => 720, 'is_free_preview' => true],
                    ['title' => 'Horizontal vs Vertical Scale', 'video_url' => 'https://www.youtube.com/watch?v=xpDnVSmNFX0', 'duration_seconds' => 540, 'is_free_preview' => true],
                    ['title' => 'Caching Strategies',           'video_url' => 'https://www.youtube.com/watch?v=dGAgxozNWFE', 'duration_seconds' => 680, 'is_free_preview' => false],
                    ['title' => 'Database Sharding',            'video_url' => 'https://www.youtube.com/watch?v=5faMjKuB9bc', 'duration_seconds' => 760, 'is_free_preview' => false],
                    ['title' => 'Message Queues',               'video_url' => 'https://www.youtube.com/watch?v=oUJbuFMyFDM', 'duration_seconds' => 590, 'is_free_preview' => false],
                    ['title' => 'Microservices Architecture',   'video_url' => 'https://www.youtube.com/watch?v=rv4LlmLmVWk', 'duration_seconds' => 830, 'is_free_preview' => false],
                ],
            ],
            [
                'level' => 'advanced',
                'title' => 'Docker & Kubernetes in Production',
                'description' => 'Container your applications and orchestrate them at scale. Learn Docker fundamentals, Kubernetes deployments, Helm charts, and CI/CD pipelines.',
                'image_url' => 'https://images.unsplash.com/photo-1605745341112-85968b19335b?w=800&h=600&fit=crop',
                'is_published' => true,
                'lessons' => [
                    ['title' => 'Docker Fundamentals',        'video_url' => 'https://www.youtube.com/watch?v=fqMOX6JJhGo', 'duration_seconds' => 780, 'is_free_preview' => true],
                    ['title' => 'Docker Compose',             'video_url' => 'https://www.youtube.com/watch?v=Qw9zlE3t8Ko', 'duration_seconds' => 640, 'is_free_preview' => false],
                    ['title' => 'Kubernetes Architecture',    'video_url' => 'https://www.youtube.com/watch?v=umXEmn3cMkY', 'duration_seconds' => 720, 'is_free_preview' => false],
                    ['title' => 'Deployments & Services',     'video_url' => 'https://www.youtube.com/watch?v=X48VuDVv0do', 'duration_seconds' => 860, 'is_free_preview' => false],
                    ['title' => 'CI/CD with GitHub Actions',  'video_url' => 'https://www.youtube.com/watch?v=R8_veQiYBjI', 'duration_seconds' => 700, 'is_free_preview' => false],
                ],
            ],
        ];

        // ── Dummy Data for Pagination Performance Testing ─────────
        for ($i = 1; $i <= 5; $i++) {
            $dummyCourse = Course::create([
                'slug' => 'test-course-'.$i,
                'level_id' => $levelModels[array_rand($levelModels)]->id,
                'title' => 'Performance Test Course '.$i,
                'description' => 'This is an autogenerated course for pagination testing. It helps ensure the UI looks great with lots of content.',
                'image' => null,
                'is_published' => true,
            ]);

            for ($j = 1; $j <= 3; $j++) {
                Lesson::create([
                    'course_id' => $dummyCourse->id,
                    'slug' => 'test-lesson-'.$i.'-'.$j,
                    'title' => 'Test Lesson '.$j,
                    'video_url' => 'o01hCiyI4Y8',
                    'duration_seconds' => random_int(300, 1200),
                    'is_free_preview' => $j === 1,
                    'order' => $j,
                ]);
            }
        }

        $courseDisk = Storage::disk('public');
        if (! $courseDisk->exists('courses')) {
            $courseDisk->makeDirectory('courses');
        }

        // ── Courses ─────
        foreach ($courses as $courseData) {
            $level = $levelModels[$courseData['level']];
            $slug = Str::slug($courseData['title']);

            $imagePath = 'courses/'.$slug.'.jpg';
            if (isset($courseData['image_url']) && ! $courseDisk->exists($imagePath)) {
                try {
                    $imageContent = Http::get($courseData['image_url'])->body();
                    $courseDisk->put($imagePath, $imageContent);
                } catch (Exception $e) {
                    $imagePath = null;
                }
            }

            $course = Course::create([
                'slug' => $slug,
                'level_id' => $level->id,
                'title' => $courseData['title'],
                'description' => $courseData['description'],
                'image' => $imagePath,
                'is_published' => $courseData['is_published'],
            ]);

            foreach ($courseData['lessons'] as $order => $lessonData) {
                $lessonSlug = Str::slug($lessonData['title']);
                Lesson::create([
                    'course_id' => $course->id,
                    'slug' => $lessonSlug,
                    'title' => $lessonData['title'],
                    'video_url' => $lessonData['video_url'],
                    'duration_seconds' => $lessonData['duration_seconds'],
                    'is_free_preview' => $lessonData['is_free_preview'],
                    'order' => $order + 1,
                ]);
            }
        }
    }
}
