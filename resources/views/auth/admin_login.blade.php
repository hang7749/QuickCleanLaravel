<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | QuickClean</title>
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
                <h1 class="mt-4 text-3xl font-black text-gray-900 tracking-tight">Admin Login</h1>
            </div>
            @if ($errors->any())
                <div class="mb-4 p-4 text-sm text-red-700 bg-red-100 rounded-2xl">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ url('/admin/login') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label class="text-xs font-bold text-gray-400 uppercase tracking-widest ml-1">Email</label>
                    <div class="relative mt-2">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                            <i class="fas fa-envelope text-sm"></i>
                        </span>
                        <input type="email" name="email" value="{{ old('email') }}" required
                            class="w-full pl-11 pr-5 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <div>
                    <label class="text-xs font-bold text-gray-400 uppercase tracking-widest">Password</label>
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
                        Sign In
                    </button>
                </div>
            </form>
        </div>
    </div>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</body>
</html>