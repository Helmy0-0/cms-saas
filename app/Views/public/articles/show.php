<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($article->title) ?> - CMS SaaS</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">

<div class="max-w-4xl mx-auto px-4 py-10">
    
    <!-- Back Link -->
    <a href="<?= site_url('/') ?>" class="inline-flex items-center text-blue-600 hover:text-blue-700 mb-6">
        <span class="mr-2">←</span> Back to Articles
    </a>

    <!-- Article -->
    <article class="bg-white rounded-xl shadow-sm p-8">
        
        <!-- Header -->
        <header class="mb-8 pb-6 border-b">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">
                <?= esc($article->title) ?>
            </h1>
            <div class="flex items-center text-sm text-gray-600 space-x-4">
                <span>By <strong><?= esc($article->author_name) ?></strong></span>
                <span>•</span>
                <time><?= date('d F Y', strtotime($article->publish_at)) ?></time>
            </div>
        </header>

        <!-- Content -->
        <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed">
            <?= nl2br(esc($article->content)) ?>
        </div>

    </article>

</div>

</body>
</html>