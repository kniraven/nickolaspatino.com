<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Employee Management System</title>
</head>
<body class="bg-gray-100">
    <header class="bg-blue-600 text-white py-4 shadow-md">
        <div class="container mx-auto px-4 flex justify-between items-center">
            <h1 class="text-xl font-bold">Employee Management System</h1>
            <!-- Mobile Menu Button -->
            <div class="md:hidden">
                <button id="menu-toggle" class="text-white focus:outline-none">
                    <!-- Hamburger icon -->
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                    </svg>
                </button>
            </div>
            <!-- Navigation Links -->
            <nav id="menu" class="hidden md:flex space-x-4">
                <a href="index.php" class="text-white hover:text-blue-200">Home</a>
                <a href="create.php" class="text-white hover:text-blue-200">Add Employee</a>
            </nav>
        </div>
        <!-- Mobile Menu Items -->
        <div id="mobile-menu" class="hidden md:hidden bg-blue-700 text-white px-4 py-2 space-y-2">
            <a href="index.php" class="block text-white hover:text-blue-200">Home</a>
            <a href="create.php" class="block text-white hover:text-blue-200">Add Employee</a>
        </div>
    </header>

    <script>
        // JavaScript to toggle mobile menu
        document.getElementById('menu-toggle').addEventListener('click', function() {
            var menu = document.getElementById('mobile-menu');
            if (menu.classList.contains('hidden')) {
                menu.classList.remove('hidden');
            } else {
                menu.classList.add('hidden');
            }
        });
    </script>
</body>
</html>
