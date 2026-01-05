<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - CMS SaaS</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">

<!-- Navigation -->
<nav class="bg-white shadow-sm border-b">
    <div class="max-w-7xl mx-auto px-4 py-4 flex items-center justify-between">
        <h1 class="text-xl font-bold text-gray-800">CMS SaaS Dashboard</h1>
        <div class="flex items-center space-x-4">
            <span class="text-sm text-gray-600">
                <?= esc(session()->get('user_role')) ?> Account
            </span>
            <a href="<?= site_url('/') ?>" class="text-sm text-blue-600 hover:text-blue-700">
                View Site
            </a>
            <a href="<?= site_url('/logout') ?>" class="text-sm text-red-600 hover:text-red-700">
                Logout
            </a>
        </div>
    </div>
</nav>

<!-- Main Content -->
<div class="max-w-7xl mx-auto px-4 py-8">
    
    <!-- Success/Error Messages -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg">
            <?= esc(session()->getFlashdata('success')) ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg">
            <?= esc(session()->getFlashdata('error')) ?>
        </div>
    <?php endif; ?>

    <!-- Header & Create Button -->
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-gray-800">My Articles</h2>
        <a href="<?= site_url('dashboard/articles/create') ?>" 
           class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition">
            + New Article
        </a>
    </div>

    <!-- Articles Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Title</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Author</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Created</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <?php if (empty($articles)): ?>
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                            No articles yet. Create your first article!
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($articles as $article): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="font-medium text-gray-900"><?= esc($article->title) ?></div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                <?= esc($article->author_name) ?>
                            </td>
                            <td class="px-6 py-4">
                                <?php 
                                $statusColors = [
                                    'draft' => 'bg-gray-100 text-gray-800',
                                    'review' => 'bg-yellow-100 text-yellow-800',
                                    'published' => 'bg-green-100 text-green-800',
                                ];
                                $color = $statusColors[$article->status] ?? 'bg-gray-100 text-gray-800';
                                ?>
                                <span class="px-2 py-1 text-xs font-semibold rounded-full <?= $color ?>">
                                    <?= ucfirst($article->status) ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                <?= date('d M Y', strtotime($article->created_at)) ?>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-2">
                                    
                                    <!-- Submit for Review (writer only, draft status) -->
                                    <?php if ($role === 'writer' && $article->status === 'draft'): ?>
                                        <form action="<?= site_url('articles/submit/' . $article->id) ?>" method="POST" class="inline">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="text-blue-600 hover:text-blue-700 text-sm">
                                                Submit
                                            </button>
                                        </form>
                                    <?php endif; ?>

                                    <!-- Approve (admin/editor only, review status) -->
                                    <?php if (in_array($role, ['admin', 'editor']) && $article->status === 'review'): ?>
                                        <form action="<?= site_url('approve/' . $article->id) ?>" method="POST" class="inline">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="text-green-600 hover:text-green-700 text-sm">
                                                Approve
                                            </button>
                                        </form>
                                        <span class="text-gray-300">|</span>
                                        <form action="<?= site_url('reject/' . $article->id) ?>" method="POST" class="inline">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="text-red-600 hover:text-red-700 text-sm">
                                                Reject
                                            </button>
                                        </form>
                                    <?php endif; ?>

                                    <!-- View published article -->
                                    <?php if ($article->status === 'published'): ?>
                                        <a href="<?= site_url('articles/' . $article->slug) ?>" 
                                           target="_blank"
                                           class="text-indigo-600 hover:text-indigo-700 text-sm">
                                            View
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>

</body>
</html>