<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }} | QuickClean</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/@supabase/supabase-js@2"></script>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex flex-col items-center justify-center px-6 py-10" style="background-color: #040319">
        <div class="text-center">
            <img src="../quick_clean.png" alt="Girl in a jacket" style="width: 250px;">
        </div>
        <div class="w-full max-w-md bg-white rounded-[2.5rem] shadow-2xl p-10 border border-gray-100">
            <div class="mb-10 text-center">
                <h1 class="mt-4 text-3xl font-black text-gray-900 tracking-tight">{{ __('page.loginTitle') }}</h1>
            </div>
            @if ($errors->any())
                <div class="mb-4 p-4 text-sm text-red-700 bg-red-100 rounded-2xl">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ url('/login') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label class="text-xs font-bold text-gray-400 uppercase tracking-widest ml-1">{{ __('page.email') }}</label>
                    <div class="relative mt-2">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                            <i class="fas fa-envelope text-sm"></i>
                        </span>
                        <input type="email" name="email" value="{{ old('email') }}" required
                            class="w-full pl-11 pr-5 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <div>
                    <label class="text-xs font-bold text-gray-400 uppercase tracking-widest">{{ __('page.passwordLabel') }}</label>
                    <div class="relative mt-2">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                            <i class="fas fa-lock text-sm"></i>
                        </span>
                        <input type="password" name="password" required
                            class="w-full pl-11 pr-5 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit" 
                        class="w-full bg-blue-600 text-white py-4 rounded-2xl font-bold text-lg shadow-xl hover:bg-blue-700 transition-all">
                        {{ __('page.loginButton') }}
                    </button>
                </div>
            </form>

            <div class="mt-8 flex items-center justify-between">
                <hr class="w-full border-gray-100">
                <span class="px-4 text-gray-300 text-xs font-bold uppercase">{{ __('page.or') }}</span>
                <hr class="w-full border-gray-100">
            </div>

            <a href="{{ route('google.login') }}"
                class="mt-6 w-full flex items-center justify-center gap-3 border border-gray-200 py-4 rounded-2xl font-bold text-gray-700 hover:bg-gray-50 transition-all">
                <img src="https://www.google.com/favicon.ico" class="w-5 h-5">
                {{ __('page.loginWithGoogle') }}
            </a>

            <a href="{{ route('facebook.login') }}"
                class="mt-4 w-full flex items-center justify-center gap-3 border border-gray-200 py-4 rounded-2xl font-bold text-gray-700 hover:bg-gray-50 transition-all">
                <i class="fab fa-facebook text-[#1877F2] text-xl"></i>
                {{ __('page.loginWithFacebook') }}
            </a>

            <p class="text-center mt-8 text-sm text-gray-500">
                {{ __('page.dontHaveAccount') }}
                <a href="{{ route('signup') }}" class="text-blue-600 font-bold cursor-pointer hover:underline">
                    <span class="text-blue-600 font-bold cursor-pointer hover:underline">
                        {{ __('page.signUp') }}
                    </span>
                </a>
            </p>

            <div class="flex justify-end p-4">
                <div class="relative group">
                    <!-- Dropdown Button -->
                    <button class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                        <span>🌐 {{ strtoupper(app()->getLocale()) }}</span>
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>

                    <!-- Dropdown Menu -->
                    <div class="absolute right-0 w-32 mt-2 origin-top-right bg-white border border-gray-200 rounded-md shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                        <div class="py-1">
                            <a href="{{ url('lang/en') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600">
                                English (EN)
                            </a>
                            <a href="{{ url('lang/zh') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600">
                                中文 (ZH)
                            </a>
                            <a href="{{ url('lang/my') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600">
                                Melayu (MY)
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script>
        document.getElementById('loginBtn').addEventListener('click', function() {
            // Show a little "loading" state to mimic Flutter's behavior
            this.innerHTML = '<i class="fas fa-circle-notch fa-spin"></i> Signing in...';
            this.style.opacity = '0.7';

            // Wait 1 second (to simulate a real login) then go to home
            setTimeout(() => {
                // Replace '/home' with whatever your home route path is
                window.location.href = '/home'; 
            }, 1000);
        });
</script>
</body>
</html>