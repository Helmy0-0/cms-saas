<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Article - CMS SaaS</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">

<!-- Navigation -->
<nav class="bg-white shadow-sm border-b">
    <div class="max-w-7xl mx-auto px-4 py-4 flex items-center justify-between">
        <h1 class="text-xl font-bold text-gray-800">Create New Article</h1>
        <a href="<?= site_url('/dashboard') ?>" class="text-sm text-gray-600 hover:text-gray-700">
            ← Back to Dashboard
        </a>
    </div>
</nav>

<!-- Main Content -->
<div class="max-w-4xl mx-auto px-4 py-8">
    
    <div class="bg-white rounded-lg shadow p-8">
        <form action="<?= site_url('articles/create') ?>" method="POST" class="space-y-6">
            <?= csrf_field() ?>
            
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
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="Enter article title"
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
                    placeholder="Write your article content here..."
                ></textarea>
            </div>

            <!-- Buttons -->
            <div class="flex items-center space-x-4">
                <button 
                    type="submit"
                    class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition"
                >
                    Save as Draft
                </button>
                <a 
                    href="<?= site_url('/dashboard') ?>" 
                    class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-lg transition"
                >
                    Cancel
                </a>
            </div>
        </form>
    </div>

</div>

</body>
</html>