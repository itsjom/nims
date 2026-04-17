<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MIIS - Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Outfit', sans-serif;
        }
    </style>
</head>

<body
    class="antialiased bg-slate-50 text-slate-800 min-h-screen flex items-center justify-center p-4 relative overflow-hidden">

    <!-- Background Decor -->
    <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 bg-green-200 rounded-full blur-3xl opacity-30"></div>
    <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-96 h-96 bg-emerald-200 rounded-full blur-3xl opacity-30"></div>

    <div class="w-full max-w-md relative z-10">
        <!-- Card -->
        <div class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-xl border border-white p-8">
            <!-- Logo & Title -->
            <div class="text-center mb-8">
                <img src="{{ asset('images/ncf-logo.png') }}" alt="NCF Logo"
                    class="w-20 h-20 mx-auto mb-4 drop-shadow-md">
                <h1 class="text-3xl font-bold text-green-700 tracking-tight">MIIS Portal</h1>
                <p class="text-slate-500 mt-2 font-medium">Please sign in to your account</p>
            </div>

            <form method="POST" action="{{ route('login.post') }}" class="space-y-5">
                @csrf

                @if ($errors->any())
                    <div class="bg-rose-50 border border-rose-100 text-rose-600 px-4 py-3 rounded-xl text-sm mb-4">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Email Address -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-slate-700 mb-1.5 ml-1">Email
                        Address</label>
                    <div
                        class="flex items-center w-full bg-slate-50 border border-slate-200 rounded-xl focus-within:border-green-500 focus-within:ring-2 focus-within:ring-green-500/20 transition-all overflow-hidden">
                        <div class="pl-4 pr-2 flex items-center justify-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207">
                                </path>
                            </svg>
                        </div>

                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                            class="block w-full py-3 pr-4 pl-4 bg-transparent border-0 focus:ring-0 focus:outline-none text-slate-800 placeholder-slate-400 font-medium"
                            placeholder="admin@miis.com">
                    </div>
                </div>

                <!-- Password -->
                <div>
                    <label for="password"
                        class="block text-sm font-semibold text-slate-700 mb-1.5 ml-1">Password</label>
                    <div
                        class="flex items-center w-full bg-slate-50 border border-slate-200 rounded-xl focus-within:border-green-500 focus-within:ring-2 focus-within:ring-green-500/20 transition-all overflow-hidden">
                        <div class="pl-4 pr-2 flex items-center justify-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                </path>
                            </svg>
                        </div>

                        <input id="password" type="password" name="password" required
                            class="block w-full py-3 pr-4 pl-4 bg-transparent border-0 focus:ring-0 focus:outline-none text-slate-800 placeholder-slate-400 font-medium"
                            placeholder="••••••••">
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-3.5 px-4 rounded-xl shadow-md transition-all hover:-translate-y-0.5 mt-2">
                    Sign In to Dashboard
                </button>
            </form>

            <div class="mt-8 pt-6 border-t border-slate-100 text-center">
                <p class="text-sm text-slate-500">
                    <a href="{{ route('borrow.create') }}"
                        class="font-semibold text-green-600 hover:text-green-500 transition-colors">Access Public
                        Borrowing Form &rarr;</a>
                </p>
            </div>
        </div>

        <div class="text-center mt-6">
            <p class="text-sm text-slate-400">&copy; {{ date('Y') }} NCF MIIS. All rights reserved.</p>
        </div>
    </div>
</body>

</html>