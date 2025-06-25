<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login - A3 Lazarus</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.2/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded shadow-md w-full max-w-md">
        <h1 class="text-2xl font-bold mb-6 text-center">Account Control Panel: Login</h1>

        <?php if (isset($validation)): ?>
            <div class="mb-4 text-red-600">
                <?= $validation->listErrors() ?>
            </div>
        <?php endif; ?>

        <?php if (isset($error)): ?>
            <div class="mb-4 text-red-600">
                <?= esc($error) ?>
            </div>
        <?php endif; ?>

        <form method="post" action="<?= site_url('logincontroller/dologin') ?>" class="space-y-6">
            <?= csrf_field() ?>
            <div>
                <label for="username" class="block mb-2 font-semibold">Username</label>
                <input type="text" id="username" name="username" required class="w-full border border-gray-300 rounded px-3 py-2" />
            </div>
            <div>
                <label for="password" class="block mb-2 font-semibold">Password</label>
                <input type="password" id="password" name="password" required class="w-full border border-gray-300 rounded px-3 py-2" />
            </div>
            <div class="flex justify-between items-center">
                <a href="<?= site_url('forgotpass') ?>" class="text-blue-600 hover:underline">Forgot Password?</a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Login</button>
            </div>
        </form>
    </div>
</body>
</html>
