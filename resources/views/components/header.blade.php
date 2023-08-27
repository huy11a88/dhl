<header>
    <div class="flex justify-between p-5 bg-gradient-to-r from-yellow-400 to-yellow-200">
        <a href={{ route('home') }}>
            <img src={{ Vite::asset('resources/images/dhl-logo.svg') }}>
        </a>
        <ul class="flex gap-4">
            @auth
                @if ($roleShippingStaff->is(auth()->user()->role))
                    <li class="hover:text-red-500">
                        <a href={{ route('my-shipping-orders') }}>My Shipping Order</a>
                    </li>
                @endif
            @endauth
            @if (!auth()->check() || auth()->check() && $roleNormalUser->is(auth()->user()->role) && !$roleCSUser->is(auth()->user()->role))
                <li class="hover:text-red-500">
                    <a href={{ route('orders.create') }}>Ship Now</a>
                </li>
            @endif
            @if (auth()->check() && $roleCSUser->is(auth()->user()->role))
                <li class="hover:text-red-500">
                    <a href={{ route('customer-service') }}>Customer Service</a>
                </li>
            @endif
            @guest
                <li class="hover:text-red-500">
                    <a href={{ route('login') }}>Portal Login</a>
                </li>
            @endguest
            @auth
                <li>
                    Hello, {{ auth()->user()->name }}
                </li>
                <li class="hover:text-red-500">
                    <form action={{ route('auth.logout') }} method="post">
                        @csrf
                        <button type="submit">Logout</button>
                    </form>
                </li>
            @endauth
        </ul>
    </div>
</header>