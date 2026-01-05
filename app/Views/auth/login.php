<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - CMS SaaS</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen flex items-center justify-center">

<div class="w-full max-w-md">
    <div class="bg-white rounded-2xl shadow-xl p-8">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800">CMS SaaS</h1>
            <p class="text-gray-600 mt-2">Sign in to your account</p>
        </div>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg">
                <p class="text-sm"><?= esc(session()->getFlashdata('error')) ?></p>
            </div>
        <?php endif; ?>

        <form action="<?= site_url('/login') ?>" method="POST" class="space-y-6">
            <?= csrf_field() ?>
            
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                    Email Address
                </label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                    placeholder="admin@gmail.com"
                >
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                    Password
                </label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                    placeholder="••••••••"
                >
            </div>

            <button 
                type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-lg transition duration-200 shadow-lg hover:shadow-xl"
            >
                Sign In
            </button>
        </form>

        <div class="mt-6 p-4 bg-gray-50 rounded-lg">
            <p class="text-xs font-semibold text-gray-700 mb-2">Demo Accounts:</p>
            <div class="text-xs text-gray-600 space-y-1">
                <p><strong>Admin:</strong> admin@gmail.com / admin123</p>
                <p><strong>Editor:</strong> editor@gmail.com / editor123</p>
                <p><strong>Writer:</strong> writer@gmail.com / writer123</p>
            </div>
        </div>

        <div class="mt-6 text-center">
            <a href="<?= site_url('/') ?>" class="text-sm text-blue-600 hover:text-blue-700">
                ← Back to Articles
            </a>
        </div>
    </div>
</div>

</body>
</html>