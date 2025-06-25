<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Register - A3 Ultimate</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.2/dist/tailwind.min.css" rel="stylesheet" />
    <script src="https://www.google.com/recaptcha/api.js?render=YOUR_RECAPTCHA_V3_SITE_KEY"></script>
    <script>
        grecaptcha.ready(function() {
            grecaptcha.execute('YOUR_RECAPTCHA_V3_SITE_KEY', {action: 'register'}).then(function(token) {
                document.getElementById('g-recaptcha-response').value = token;
            });
        });
    </script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded shadow-md w-full max-w-lg">
        <h1 class="text-2xl font-bold mb-6 text-center">Register New Account</h1>

        <?php if (isset($validation)): ?>
            <div class="mb-4 text-red-600">
                <?= $validation->listErrors() ?>
            </div>
        <?php endif; ?>

        <?php if (isset($recaptchaError)): ?>
            <div class="mb-4 text-red-600">
                <?= esc($recaptchaError) ?>
            </div>
        <?php endif; ?>

        <?php if (isset($successMessage)): ?>
            <div class="mb-4 text-green-600">
                <?= esc($successMessage) ?>
            </div>
        <?php endif; ?>

        <form method="post" action="<?= site_url('registrationcontroller/register') ?>" class="space-y-4">
            <?= csrf_field() ?>
            <div>
                <label for="fullname" class="block mb-1 font-semibold">Full Name</label>
                <input type="text" id="fullname" name="fullname" value="<?= set_value('fullname') ?>" required class="w-full border border-gray-300 rounded px-3 py-2" />
            </div>
            <div>
                <label for="username" class="block mb-1 font-semibold">Username</label>
                <input type="text" id="username" name="username" value="<?= set_value('username') ?>" required class="w-full border border-gray-300 rounded px-3 py-2" />
            </div>
            <div>
                <label for="email" class="block mb-1 font-semibold">Email</label>
                <input type="email" id="email" name="email" value="<?= set_value('email') ?>" required class="w-full border border-gray-300 rounded px-3 py-2" />
            </div>
            <div>
                <label for="password" class="block mb-1 font-semibold">Password</label>
                <input type="password" id="password" name="password" required class="w-full border border-gray-300 rounded px-3 py-2" />
            </div>
            <div>
                <label for="rpassword" class="block mb-1 font-semibold">Confirm Password</label>
                <input type="password" id="rpassword" name="rpassword" required class="w-full border border-gray-300 rounded px-3 py-2" />
            </div>
            <div>
                <label for="tel" class="block mb-1 font-semibold">Phone Number</label>
                <input type="tel" id="tel" name="tel" value="<?= set_value('tel') ?>" required class="w-full border border-gray-300 rounded px-3 py-2" />
            </div>
            <div>
                <label for="question" class="block mb-1 font-semibold">Secret Question</label>
                <input type="text" id="question" name="question" value="<?= set_value('question') ?>" required class="w-full border border-gray-300 rounded px-3 py-2" />
            </div>
            <div>
                <label for="answer" class="block mb-1 font-semibold">Secret Answer</label>
                <input type="text" id="answer" name="answer" value="<?= set_value('answer') ?>" required class="w-full border border-gray-300 rounded px-3 py-2" />
            </div>
            <div>
                <label for="trnxpass" class="block mb-1 font-semibold">Transaction Password</label>
                <input type="password" id="trnxpass" name="trnxpass" required class="w-full border border-gray-300 rounded px-3 py-2" />
            </div>
            <div>
                <label for="referrer" class="block mb-1 font-semibold">Referrer (Optional)</label>
                <input type="text" id="referrer" name="referrer" value="<?= set_value('referrer') ?>" class="w-full border border-gray-300 rounded px-3 py-2" />
            </div>
            <div class="flex items-center">
                <input type="checkbox" id="accept_terms" name="accept_terms" value="1" required class="mr-2" />
                <label for="accept_terms" class="text-sm">I accept the <a href="/TermsOfServices/" class="text-blue-600 hover:underline" target="_blank">Terms of Service</a>, <a href="/RefundPolicy/" class="text-blue-600 hover:underline" target="_blank">Refund Policy</a>, and <a href="/PrivacyPolicy/" class="text-blue-600 hover:underline" target="_blank">Privacy Policy</a>.</label>
            </div>
            <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response" />
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 w-full">Register</button>
        </form>
    </div>
</body>
</html>
