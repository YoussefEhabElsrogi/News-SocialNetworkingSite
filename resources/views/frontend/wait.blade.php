<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Wait</title>
    <!-- Include Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />
</head>

<body class="bg-gradient-to-br from-blue-50 to-blue-100 flex items-center justify-center h-screen">
    <div
        class="max-w-lg bg-white p-10 rounded-2xl shadow-lg text-center transform transition-all duration-300 hover:scale-105">
        <div class="mb-8">
            <div class="flex justify-center">
                <svg class="animate-spin h-16 w-16 text-blue-500 mb-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                        stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A8.003 8.003 0 0112 4.018V0C6.477 0 2 4.477 2 10h4zm2 6.764V20c5.523 0 10-4.477 10-10h-4a6 6 0 00-6 6z">
                    </path>
                </svg>
            </div>
            <h2 class="text-3xl font-bold text-gray-800 mb-4">Please Wait</h2>
            <p class="text-gray-600 text-lg">
                Oops! You are currently <span class="text-red-500 font-bold">blocked</span>.
            </p>
        </div>
        <a href="{{ route('front.dashboard.profile') }}"
            class="inline-block px-6 py-3 bg-blue-500 text-white font-semibold rounded-lg shadow-lg hover:bg-blue-600 transition duration-200">
            Refresh
        </a>
        <hr class="my-6 border-gray-300" />
        <p class="text-sm text-gray-500">
            This is a waiting page. We appreciate your patience.
        </p>
    </div>
</body>

</html>
