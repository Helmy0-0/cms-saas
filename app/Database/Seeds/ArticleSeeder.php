<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ArticleSeeder extends Seeder
{
    public function run()
    {
        $articles = [
            [
                'title' => 'Mengenal Clean Architecture di Backend',
                'slug' => 'mengenal-clean-architecture-backend',
                'content' => 'Clean Architecture membantu memisahkan domain logic dari framework. Dengan memisahkan business logic dari infrastructure, aplikasi menjadi lebih mudah di-test dan di-maintain. Konsep ini sangat berguna untuk project berskala besar.',
                'status' => 'published',
                'author_id' => 1,
                // 'publish_at' => date('Y-m-d H:i:s', strtotime('-10 days')),
                'created_at' => date('Y-m-d H:i:s', strtotime('-10 days')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-10 days')),
            ],
            [
                'title' => 'Kenapa REST API Harus Konsisten',
                'slug' => 'kenapa-rest-api-harus-konsisten',
                'content' => 'Konsistensi response API akan sangat membantu frontend developer. Dengan format response yang konsisten, frontend tidak perlu melakukan banyak handling untuk berbagai case. Standard seperti status code, error message format, dan data structure harus dijaga.',
                'status' => 'published',
                'author_id' => 2,
                // 'publish_at' => date('Y-m-d H:i:s', strtotime('-9 days')),
                'created_at' => date('Y-m-d H:i:s', strtotime('-9 days')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-9 days')),
            ],
            [
                'title' => 'Implementasi SOLID Principles di PHP',
                'slug' => 'implementasi-solid-principles-php',
                'content' => 'SOLID adalah 5 prinsip dasar object-oriented programming yang membuat kode lebih maintainable. Single Responsibility, Open/Closed, Liskov Substitution, Interface Segregation, dan Dependency Inversion adalah fondasi penting dalam software engineering.',
                'status' => 'published',
                'author_id' => 1,
                // 'publish_at' => date('Y-m-d H:i:s', strtotime('-8 days')),
                'created_at' => date('Y-m-d H:i:s', strtotime('-8 days')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-8 days')),
            ],
            [
                'title' => 'Keamanan Web: Mencegah SQL Injection',
                'slug' => 'keamanan-web-mencegah-sql-injection',
                'content' => 'SQL Injection adalah salah satu vulnerability paling berbahaya di web application. Gunakan prepared statements dan parameterized queries untuk mencegahnya. Never trust user input dan selalu lakukan validation dan sanitization.',
                'status' => 'published',
                'author_id' => 3,
                // 'publish_at' => date('Y-m-d H:i:s', strtotime('-7 days')),
                'created_at' => date('Y-m-d H:i:s', strtotime('-7 days')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-7 days')),
            ],
            [
                'title' => 'Docker untuk Development Environment',
                'slug' => 'docker-untuk-development-environment',
                'content' => 'Docker memudahkan setup development environment yang konsisten di semua tim. Dengan containerization, dependencies dan configuration bisa di-share dengan mudah. Tidak ada lagi "works on my machine" problem.',
                'status' => 'published',
                'author_id' => 2,
                // 'publish_at' => date('Y-m-d H:i:s', strtotime('-6 days')),
                'created_at' => date('Y-m-d H:i:s', strtotime('-6 days')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-6 days')),
            ],
            [
                'title' => 'Optimasi Database Query di Laravel',
                'slug' => 'optimasi-database-query-laravel',
                'content' => 'N+1 query problem adalah masalah umum yang memperlambat aplikasi. Gunakan eager loading, indexing yang tepat, dan query optimization untuk meningkatkan performance. Monitoring query dengan tools seperti Laravel Debugbar sangat membantu.',
                'status' => 'published',
                'author_id' => 1,
                // 'publish_at' => date('Y-m-d H:i:s', strtotime('-5 days')),
                'created_at' => date('Y-m-d H:i:s', strtotime('-5 days')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-5 days')),
            ],
            [
                'title' => 'Git Workflow: Feature Branch vs Trunk Based',
                'slug' => 'git-workflow-feature-branch-trunk-based',
                'content' => 'Memilih git workflow yang tepat sangat penting untuk produktivitas tim. Feature branch cocok untuk project besar dengan banyak developer, sementara trunk based development cocok untuk team kecil yang bergerak cepat.',
                'status' => 'published',
                'author_id' => 3,
                // 'publish_at' => date('Y-m-d H:i:s', strtotime('-4 days')),
                'created_at' => date('Y-m-d H:i:s', strtotime('-4 days')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-4 days')),
            ],
            [
                'title' => 'Testing Pyramid: Unit, Integration, E2E',
                'slug' => 'testing-pyramid-unit-integration-e2e',
                'content' => 'Testing pyramid menunjukkan proporsi ideal dari berbagai jenis test. Banyak unit test di base karena cepat dan murah, sedikit integration test di tengah, dan minimal E2E test di puncak karena lambat dan mahal.',
                'status' => 'published',
                'author_id' => 2,
                // 'publish_at' => date('Y-m-d H:i:s', strtotime('-3 days')),
                'created_at' => date('Y-m-d H:i:s', strtotime('-3 days')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-3 days')),
            ],
            [
                'title' => 'Microservices vs Monolith: Kapan Harus Migrate?',
                'slug' => 'microservices-vs-monolith-kapan-migrate',
                'content' => 'Tidak semua aplikasi butuh microservices. Monolith yang well-designed lebih baik daripada microservices yang prematur. Pertimbangkan team size, scaling needs, dan complexity sebelum memutuskan arsitektur.',
                'status' => 'published',
                'author_id' => 1,
                // 'publish_at' => date('Y-m-d H:i:s', strtotime('-2 days')),
                'created_at' => date('Y-m-d H:i:s', strtotime('-2 days')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-2 days')),
            ],
            [
                'title' => 'API Versioning: Best Practices',
                'slug' => 'api-versioning-best-practices',
                'content' => 'API versioning penting untuk backward compatibility. URL versioning (v1, v2) adalah cara paling mudah dan eksplisit. Header versioning lebih clean tapi kurang visible. Deprecation policy dan documentation yang jelas sangat penting.',
                'status' => 'published',
                'author_id' => 3,
                // 'publish_at' => date('Y-m-d H:i:s', strtotime('-1 day')),
                'created_at' => date('Y-m-d H:i:s', strtotime('-1 day')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-1 day')),
            ],
            [
                'title' => 'Redis Caching Strategy untuk High Traffic',
                'slug' => 'redis-caching-strategy-high-traffic',
                'content' => 'Redis adalah pilihan tepat untuk caching di aplikasi high traffic. Cache-aside pattern, write-through, dan write-behind adalah strategy yang umum digunakan. TTL dan cache invalidation harus dipikirkan dengan matang.',
                'status' => 'published',
                'author_id' => 2,
                // 'publish_at' => date('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Draft: CI4 Service Layer',
                'slug' => 'draft-ci4-service-layer',
                'content' => 'Artikel ini masih draft...',
                'status' => 'draft',
                'author_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('articles')->insertBatch($articles);
    }
}
