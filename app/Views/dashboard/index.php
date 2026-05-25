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
                <span>
                    Hello, <?= esc(session()->get('name') ?? 'User') ?>
                </span>
                <span class="text-sm text-gray-600">
                    <?= esc(session()->get('user_role')) ?>
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

        <?php if ($role === 'admin'): ?>
            <div class="mb-8 bg-white rounded-lg shadow overflow-hidden">
                <div class="px-6 py-4 border-b bg-gray-50">
                    <h2 class="text-xl font-bold text-gray-800">User Management</h2>
                </div>
                
                <table class="w-full">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Current Role</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php if (empty($users)): ?>
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-gray-500">No users found.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($users as $user): ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 font-medium text-gray-900"><?= esc($user->name) ?></td>
                                    <td class="px-6 py-4 text-sm text-gray-600"><?= esc($user->email) ?></td>
                                    <td class="px-6 py-4 text-sm text-gray-600"><?= esc($user->role) ?></td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center space-x-3">
                                            <a href="<?= site_url('dashboard/users/' . $user->id . '/articles') ?>"
                                                class="text-sm text-blue-600 hover:text-blue-700 font-medium">
                                                View Articles
                                            </a>
                                            <form action="<?= site_url('dashboard/users/' . $user->id . '/role') ?>" method="POST"
                                                class="flex items-center space-x-2">
                                                <?= csrf_field() ?>
                                                <select name="role"
                                                    class="text-sm border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                                                    <?php $availableRoles = ['writer', 'editor', 'admin']; ?>
                                                    <?php foreach ($availableRoles as $availableRole): ?>
                                                        <option value="<?= esc($availableRole) ?>" <?= $user->role === $availableRole ? 'selected' : '' ?>>
                                                            <?= ucfirst($availableRole) ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <button type="submit"
                                                    class="px-3 py-1.5 text-xs bg-gray-500 text-white rounded hover:bg-gray-700">
                                                    Update Role
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>

        <!-- Header & Create Button -->
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-800">
                <?php if (!empty($selectedUser)): ?>
                    Articles by <?= esc($selectedUser->name) ?>
                <?php else: ?>
                    All Articles
                <?php endif; ?>
            </h2>
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
                                    <div class="flex items-center space-x-2 text-sm">

                                        <!-- WRITER ACTIONS -->
                                        <?php if ($role === 'writer'): ?>

                                            <!-- Edit (draft only) -->
                                            <?php if ($article->status === 'draft'): ?>
                                                <a href="<?= site_url('articles/edit/' . $article->id) ?>"
                                                    class="text-blue-600 hover:text-blue-700">
                                                    Edit
                                                </a>
                                                <span class="text-gray-300">|</span>
                                            <?php endif; ?>

                                            <!-- Submit for Review (draft only) -->
                                            <?php if ($article->status === 'draft'): ?>
                                                <form action="<?= site_url('articles/submit/' . $article->id) ?>" method="POST"
                                                    class="inline">
                                                    <?= csrf_field() ?>
                                                    <button type="submit" class="text-green-600 hover:text-green-700">
                                                        Submit for Review
                                                    </button>
                                                </form>
                                            <?php endif; ?>

                                            <!-- Takedown (published only) -->
                                            <?php if ($article->status === 'published'): ?>
                                                <form action="<?= site_url('articles/takedown/' . $article->id) ?>" method="POST"
                                                    class="inline"
                                                    onsubmit="return confirm('Takedown this article? It will return to draft status.')">
                                                    <?= csrf_field() ?>
                                                    <button type="submit" class="text-orange-600 hover:text-orange-700">
                                                        Takedown
                                                    </button>
                                                </form>
                                            <?php endif; ?>

                                            <!-- View Published -->
                                            <?php if ($article->status === 'published'): ?>
                                                <span class="text-gray-300">|</span>
                                                <a href="<?= site_url('articles/' . $article->slug) ?>" target="_blank"
                                                    class="text-indigo-600 hover:text-indigo-700">
                                                    View
                                                </a>
                                            <?php endif; ?>

                                        <?php endif; ?>

                                        <!-- EDITOR/ADMIN ACTIONS -->
                                        <?php if (in_array($role, ['admin', 'editor'])): ?>

                                            <!-- Edit (review status) -->
                                            <?php if ($article->status === 'review'): ?>
                                                <a href="<?= site_url('articles/edit/' . $article->id) ?>"
                                                    class="text-purple-600 hover:text-purple-700 font-semibold">
                                                    Edit & Publish
                                                </a>
                                                <span class="text-gray-300">|</span>
                                            <?php endif; ?>

                                            <!-- Approve (review status) -->
                                            <?php if ($article->status === 'review'): ?>
                                                <form action="<?= site_url('approve/' . $article->id) ?>" method="POST" class="inline">
                                                    <?= csrf_field() ?>
                                                    <button type="submit" class="text-green-600 hover:text-green-700">
                                                        Approve
                                                    </button>
                                                </form>
                                                <span class="text-gray-300">|</span>
                                                <form action="<?= site_url('reject/' . $article->id) ?>" method="POST" class="inline">
                                                    <?= csrf_field() ?>
                                                    <button type="submit" class="text-red-600 hover:text-red-700">
                                                        Reject
                                                    </button>
                                                </form>
                                            <?php endif; ?>

                                            <!-- Publish Now (draft status) -->
                                            <?php if ($article->status === 'draft'): ?>
                                                <form action="<?= site_url('publish/' . $article->id) ?>" method="POST" class="inline">
                                                    <?= csrf_field() ?>
                                                    <button type="submit" class="text-green-600 hover:text-green-700 font-semibold">
                                                        Publish Now
                                                    </button>
                                                </form>
                                            <?php endif; ?>

                                            <!-- View Published -->
                                            <?php if ($article->status === 'published'): ?>
                                                <a href="<?= site_url('articles/' . $article->slug) ?>" target="_blank"
                                                    class="text-indigo-600 hover:text-indigo-700">
                                                    View
                                                </a>
                                            <?php endif; ?>

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