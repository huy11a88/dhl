<x-layout>
    <div class="flex justify-center items-center min-h-[400px] my-8">
        <div class="flex px-[50px] flex-col gap-5 py-10 bg-gray-50 rounded-md w-[50%]">
            <img src={{ Vite::asset('resources/images/thank.png') }} class="w-[12rem] mx-auto">
            <p class="text-xl underline">Your order detail:</p>
            <div class="grid grid-cols-5">
                <div class="col-span-2 flex flex-col gap-2">
                    <p>Customer Name:</p>
                    <p>Order Number:</p>
                    <p>Recipient Address:</p>
                    <p>Shipping Address:</p>
                    <p>Shipping Date:</p>
                    <p>Expected Delivery Date:</p>
                    <p>Created Date:</p>
                </div>
                <div class="col-span-3 flex flex-col gap-2">
                    <p>{{ $customerName }}</p>
                    <p>{{ $order->order_number }}</p>
                    <p>{{ $order->recipient_address }}</p>
                    <p>{{ $order->shipping_address }}</p>
                    <p>{{ $order->shipping_date->format('Y/m/d') }}</p>
                    <p>{{ $order->expected_delivery_date->format('Y/m/d') }}</p>
                    <p>{{ $order->created_at->format('Y/m/d H:i:s') }}</p>
                </div>
            </div>
            <a href={{ route('home') }} class="bg-yellow-400 font-bold p-2 w-full mb-2 text-center" type="button">Go Home</a>
        </div>
    </div>
</x-layout>