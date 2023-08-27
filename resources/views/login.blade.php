<x-layout title='Portal Login'>
    <div class="flex justify-center items-center min-h-[500px]">
        <form action={{ route('auth.login') }} method="post">
            @csrf
            <input type="hidden" name="redirect-to" value={{ $redirectTo }}>
            <div class="flex px-[50px] flex-col gap-6 py-5 bg-gray-50 rounded-md w-[400px]">
                <h1 class="text-center text-2xl">Login</h1>
                <label for="email" class="block">
                    <span>Email</span>
                    <input id="email" type="email" name="email" class="block w-full" placeholder="Your email" />
                </label>
                <label for="password" class="block">
                    <span>Password</span>
                    <input id="password" type="password" name="password" class="block w-full" placeholder="Your password" />
                </label>
                <div>
                    <button type="submit" class="bg-yellow-400 font-bold p-2 w-full mb-2">Login</button>
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                        <p class="text-red-500">{{ $error }}</p>
                        @endforeach
                    @endif
                </div>
                <p>
                    <span class="font-bold text-gray-600">Not registered?</span>
                    <a href={{ route('register') }} class="text-blue-500">Register Now</a>
                </p>
            </div>
        </form>
    </div>
</x-layout>