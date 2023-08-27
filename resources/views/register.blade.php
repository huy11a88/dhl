<x-layout title="Register">
    <div class="flex justify-center items-center min-h-[600px]">
        <form action={{ route('auth.register') }} method="post">
            @csrf
            <div class="flex px-[50px] flex-col gap-5 py-5 bg-gray-50 rounded-md w-[500px]">
                <h1 class="text-center text-2xl">Register</h1>
                <label for="name" class="block">
                    <span>Name</span>
                    <input id="name" type="text" name="name" class="block w-full" placeholder="Your name" />
                </label>
                <label for="email" class="block">
                    <span>Email</span>
                    <input id="email" type="email" name="email" class="block w-full" placeholder="Your email" />
                </label>
                <label for="password" class="block">
                    <span>Password</span>
                    <input id="password" type="password" name="password" class="block w-full" placeholder="Password" />
                </label>
                <label for="password" class="block">
                    <span>Confirm Password</span>
                    <input id="password" type="password" name="password_confirmation" class="block w-full" placeholder="Confirm password" />
                </label>
                <div>
                    <button type="submit" class="bg-yellow-400 font-bold p-2 w-full mb-2">Register</button>
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                        <p class="text-red-500">{{ $error }}</p>
                        @endforeach
                    @endif
                </div>
                <p>
                    <span class="font-bold text-gray-600">Already have an account?</span>
                    <a href={{ route('login') }} class="text-blue-500">Login</a>
                </p>
            </div>
        </form>
    </div>
</x-layout>