<x-layout title="New order">
    @guest
        <div class="flex justify-center items-center min-h-[400px]">
            <div class="flex px-[50px] flex-col gap-5 py-5 bg-gray-50 rounded-md w-fit">
                <p class="text-2xl">Please login to make an order!</p>
                <img src={{ Vite::asset('resources/images/oops.png') }}>
                <a href={{ route('login', ['redirect_to' => 'orders.create']) }} class="bg-yellow-400 font-bold p-2 w-full mb-2 text-center" type="button">Login</a>
            </div>
        </div>
    @endguest
    @auth
        <div class="sm:px-[5%] md:px-[15%] xl:px-[20%] 2xl:px-[25%] pt-[40px] text-center">
            <h1 class="text-5xl font-bold text-red-600 mb-[40px]">GET A FREE DOMESTIC OR INTERNATIONAL BUSINESS SHIPPING QUOTE ONLINE</h1>
            <p>Packages and pallets, big and small, we can offer you an instant quote for your shipping needs both domestically and internationally. Fill out your shipment details below to discover your quotes. If you are satisfied, simply continue to book.</p>
        </div>
        <div class="flex 2xl:px-[15%] gap-[50px] mt-[40px]">
            <div class="flex flex-col text-center">
                <p class="text-4xl text-red-600 font-bold">1.</p>
                <p class="font-bold">ENTER ORIGIN AND DESTINATION</p>
            </div>
            <div class="flex flex-col text-center">
                <p class="text-4xl text-red-600 font-bold">2.</p>
                <p class="font-bold">COMPLETE YOUR SHIPMENT DETAILS</p>
            </div>
            <div class="flex flex-col text-center">
                <p class="text-4xl text-red-600 font-bold">3.</p>
                <p class="font-bold">GET AN ESTIMATED QUOTE</p>
            </div>
            <div class="flex flex-col text-center">
                <p class="text-4xl text-red-600 font-bold">4.</p>
                <p class="font-bold">PROCEED WITH ONLINE BOOKING</p>
            </div>
        </div>
        <form action={{ route('orders.store') }} method="post">
            <div class="flex flex-col gap-4 bg-gray-50 my-[30px] py-[40px] px-[20%]">
                <h1 class="text-3xl font-bold">New Order</h1>
                @csrf
                <label for="recipient_address" class="block">
                    <span>From</span>
                    <input id="recipient_address" type="text" name="recipient_address" class="block w-full" placeholder="Recipient address" value="{{ old('recipient_address') }}" />
                    @error('recipient_address')
                        <p class="text-red-500">{{ $message }}</p>
                    @enderror
                </label>
                <label for="shipping_address" class="block">
                    <span>To</span>
                    <input id="shipping_address" type="text" name="shipping_address" class="block w-full" placeholder="Shipping address" value="{{ old('shipping_address') }}" />
                    @error('shipping_address')
                        <p class="text-red-500">{{ $message }}</p>
                    @enderror
                </label>
                <label for="shipping_date" class="block">
                    <span>Shipping Date</span>
                    <input id="shipping_date" type="datetime-local" name="shipping_date" class="block w-full" value="{{ old('shipping_date') }}" />
                    @error('shipping_date')
                        <p class="text-red-500">{{ $message }}</p>
                    @enderror
                </label>
                <div class="text-center mt-5">
                    <button type="submit" class="text-white bg-red-600 px-7 font-medium py-2 rounded">Make An Order</button>
                </div>
            </div>
        </form>
    @endauth
</x-layout>