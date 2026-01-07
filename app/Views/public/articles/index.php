<!-- app/Views/public/articles/index.php -->
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Articles</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 text-gray-900">
    <nav class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 py-4 flex items-center justify-between">
            <h1 class="text-xl font-bold text-gray-800">CMS SaaS</h1>
            <div class="flex items-center space-x-4">
                <span class="text-sm text-gray-600"> Welcome, 
                    <?= esc(session()->get('user_role')) ?>
                </span>
                <a href="<?= site_url('/logout') ?>" class="text-sm text-red-600 hover:text-red-700">
                    Logout
                </a>
            </div>
        </div>
    </nav>

    <div class="max-w-6xl mx-auto px-4 py-10">
        <header class="mb-8">
            <h1 class="text-3xl font-bold">Latest Articles</h1>
            <p class="text-gray-600 mt-2">Insights, updates, and long-form thoughts</p>
        </header>

        <!-- Article Grid -->
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            <?php foreach ($articles as $article): ?>
                <article class="bg-white rounded-xl shadow-sm hover:shadow-md transition overflow-hidden">
                    <div class="p-5 flex flex-col h-full">
                        <h2 class="text-xl font-semibold leading-snug mb-2">
                            <a href="<?= site_url('articles/' . $article->slug) ?>" class="hover:underline">
                                <?= esc($article->title) ?>
                            </a>
                        </h2>

                        <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                            <?= esc(substr(strip_tags($article->content), 0, 150)) ?>...
                        </p>

                        <div class="mt-auto flex items-center justify-between text-xs text-gray-500">
                            <span><?= date('d M Y', strtotime($article->publish_at)) ?></span>
                            <span class="uppercase tracking-wide"><?= esc($article->author_name ?? 'Unknown') ?></span>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>

        <!-- Pagination -->
        <div class="mt-10">
            <?= $pager->links('default', 'tailwind_full') ?>
        </div>
    </div>

</body>

</html>