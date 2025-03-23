<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <title>InvoicePurple - Professional Invoice Generator</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0fdf4',
                            100: '#dcfce7',
                            500: '#22c55e',
                            600: '#16a34a',
                            700: '#15803d',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body>
    <nav class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <span class="text-2xl font-bold text-primary-600">Invoice<span class="text">Purple</span></span>
                </div>
                <div class="flex items-center space-x-4">
                    
                    
                    @if (Auth::user())
                    <form action="{{ route('logout')}}" method="POST">
                        @csrf
                        <button class="text-gray-600 hover:text-primary-600"> Logout </button>
                    </form>
                    @else
                    
                    <a href="{{ route('login')}}" class="text-gray-600 hover:text-primary-600"> Login </a>
                    @endif
                    <a href="{{ route('register')}}" class="text-gray-600 hover:text-primary-600"> Register </a>
                    <a href="#" class="text-gray-600 hover:text-primary-600">{{ Auth::user()->name ?? '' }}</a>
                    <a href="{{ route('generate.invoice')}}" class="bg-primary-600 text-white px-4 py-2 rounded-lg hover:bg-primary-700">Get Started</a>
                </div>
            </div>
        </div>
    </nav>
    <main class="py-4">
            @yield('content')
    </main>
</body>
</html>
