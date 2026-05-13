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
    <div class="min-h-screen flex flex-col bg-black items-center justify-center px-6 py-10" style="background-color: #040319">
        <div class="text-center">
            <img src="../quick_clean.png" alt="Girl in a jacket" style="width: 250px;">
        </div>
        <div class="w-full max-w-md bg-white rounded-[2.5rem] shadow-xl p-8 border border-gray-100">
            <div class="mb-10 text-center">
                <h1 class="mt-4 text-3xl font-black text-gray-900 tracking-tight">{{ __('page.signUp') }}</h1>
            </div>

            @if ($errors->any())
                <div class="mb-4 p-4 text-sm text-red-700 bg-red-100 rounded-2xl">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ url('/signup') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="text-xs font-bold text-gray-400 uppercase ml-1">{{ __('page.fullName') }}</label>
                    <input type="text" name="username" value="{{ old('username') }}" placeholder="{{ __('page.enterAName') }}" required
                        class="w-full mt-1 px-5 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-blue-500 transition-all">
                </div>


                <div>
                    <label class="text-xs font-bold text-gray-400 uppercase ml-1">{{ __('page.emailLabel') }}</label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="{{ __('page.emailHint') }}" required
                        class="w-full mt-1 px-5 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-blue-500 transition-all">
                </div>

                <div>
                    <label class="text-xs font-bold text-gray-400 uppercase ml-1">{{ __('page.passwordLabel') }}</label>
                    <input type="password" name="password" placeholder="{{ __('page.passwordHint') }}" required
                        class="w-full mt-1 px-5 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-blue-500 transition-all">
                </div>

                <button type="submit" class="w-full bg-blue-600 text-white py-4 rounded-2xl font-bold shadow-lg shadow-blue-200 active:scale-95 transition-transform mt-4">
                    {{ __('page.signUp') }}
                </button>
            </form>

            <p class="text-center mt-8 text-sm text-gray-500">
                {{ __('page.alreadyHaveAccount') }}
                <a href="{{ route('login') }}" class="text-blue-600 font-bold cursor-pointer hover:underline">
                    {{ __('page.loginButton') }}
                </a>
            </p>
        </div>
    </div>
</body>
</html>