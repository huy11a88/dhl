<x-layout title="Edit order">
    <form action={{ route('orders.update', ['order' => $order->id]) }} method="post">
        <div class="flex flex-col gap-4 bg-gray-50 my-[30px] py-[40px] px-[20%]">
            <h1 class="text-3xl font-bold">Edit Order #{{ $order->id }}</h1>
            @method('PUT')
            @csrf
            <input type="hidden" name="id" value={{ $order->id }}>
            <label for="recipient_address" class="block">
                <span>From</span>
                <input id="recipient_address" type="text" name="recipient_address" class="block w-full" placeholder="Recipient address" value="{{ $order->recipient_address }}" />
                @error('recipient_address')
                    <p class="text-red-500">{{ $message }}</p>
                @enderror
            </label>
            <label for="shipping_address" class="block">
                <span>To</span>
                <input id="shipping_address" type="text" name="shipping_address" class="block w-full" placeholder="Shipping address" value="{{ $order->shipping_address }}" />
                @error('shipping_address')
                    <p class="text-red-500">{{ $message }}</p>
                @enderror
            </label>
            <label for="shipping_date" class="block">
                <span>Shipping Date</span>
                <input id="shipping_date" type="datetime-local" name="shipping_date" class="block w-full" value="{{ old('shipping_date') ?? $order->shipping_date }}" />
                @error('shipping_date')
                    <p class="text-red-500">{{ $message }}</p>
                @enderror
            </label>
            <div class="flex gap-3 justify-center mt-5">
                <a type="button" class="bg-yellow-400 px-7 font-medium py-2 rounded" href={{ route('orders.show', ['order' => $order->id]) }}>Back</a>
                <button type="submit" class="bg-green-500 px-7 font-medium py-2 rounded text-white">Update</button>
            </div>
        </div>
    </form>
</x-layout>