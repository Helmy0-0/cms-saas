<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Article - CMS SaaS</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">

<nav class="bg-white shadow-sm border-b">
    <div class="max-w-7xl mx-auto px-4 py-4 flex items-center justify-between">
        <h1 class="text-xl font-bold text-gray-800">Edit Article</h1>
        <a href="<?= site_url('/dashboard') ?>" class="text-sm text-gray-600 hover:text-gray-700">
            ← Back to Dashboard
        </a>
    </div>
</nav>

<div class="max-w-4xl mx-auto px-4 py-8">
    
    <div class="bg-white rounded-lg shadow p-8">
        <form action="<?= site_url('articles/update/' . $article->id) ?>" method="POST" class="space-y-6">
            <?= csrf_field() ?>
            
            <!-- Status Badge -->
            <div class="p-4 bg-blue-50 rounded-lg">
                <p class="text-sm text-blue-800">
                    <strong>Status:</strong> <?= ucfirst($article->status) ?>
                    <?php if ($role === 'editor' && $article->status === 'review'): ?>
                        <span class="ml-2 text-xs">(Editing will automatically publish this article)</span>
                    <?php endif; ?>
                </p>
            </div>

            <!-- Title -->
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                    Article Title *
                </label>
                <input 
                    type="text" 
                    id="title" 
                    name="title" 
                    required
                    value="<?= esc($article->title) ?>"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                >
            </div>

            <!-- Content -->
            <div>
                <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
                    Content *
                </label>
                <textarea 
                    id="content" 
                    name="content" 
                    required
                    rows="15"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                ><?= esc($article->content) ?></textarea>
            </div>

            <!-- Buttons -->
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <button 
                        type="submit"
                        class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition"
                    >
                        <?= ($role === 'editor' && $article->status === 'review') ? 'Update & Publish' : 'Update Article' ?>
                    </button>
                    <a 
                        href="<?= site_url('/dashboard') ?>" 
                        class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-lg transition"
                    >
                        Cancel
                    </a>
                </div>

                <!-- Delete Button (hanya untuk writer di draft) -->
                <?php if ($role === 'writer' && $article->status === 'draft'): ?>
                    <form action="<?= site_url('articles/delete/' . $article->id) ?>" method="POST" 
                          onsubmit="return confirm('Are you sure you want to delete this article? This action cannot be undone.')">
                        <?= csrf_field() ?>
                        <button 
                            type="submit"
                            class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition"
                        >
                            Delete Article
                        </button>
                    </form>
                <?php endif; ?>
            </div>
        </form>
    </div>

</div>

</body>
</html>