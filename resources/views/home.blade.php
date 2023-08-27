<x-layout>
    <div class="py-[100px] px-[50px]">
        <h1 class="text-3xl">All Orders</h1>
        <div class="mb-2 mt-3">
            <form action={{ route('orders.index') }} method="get" class="flex gap-2 items-end">
                <label for="search-text" class="block">
                    <span>Tracking number</span>
                    <input type="text" id="search-text" class="w-[300px] max-w-[400px] block" name="search-text" placeholder="Enter order number or name... " value="{{ old('search-text') ?? '' }}" />
                </label>
                <label for="search-shipping-date" class="block">
                    <span>Shipping date</span>
                    <input type="date" id="search-shipping-date" name="search-shipping-date" class="block" value="{{ old('search-shipping-date') }}" />
                </label>
                <button type="submit" class="bg-yellow-400 px-4 h-[42px] font-medium">Search orders</button>
                <button type="reset" class="bg-red-500 px-4 h-[42px] font-medium text-white" onclick="location.href='{{ route('home') }}'">Clear</button>
            </form>
        </div>
        <div class="relative overflow-x-auto shadow-md rounded-md border">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        @if ($isShippingStaff)
                            <th scope="col" class="px-6 py-3 w-1/5">
                                Order Number
                            </th>
                            <th scope="col" class="px-6 py-3 w-1/5">
                                Customer Name
                            </th>
                            <th scope="col" class="px-6 py-3 w-1/5">
                                Shipping Date
                            </th>
                            <th scope="col" class="px-6 py-3 w-1/5">
                                Expected Delivery Date
                            </th>
                            <th scope="col" class="px-6 py-3 w-1/5">
                                Action
                            </th>
                        @else
                            <th scope="col" class="px-6 py-3 w-1/4">
                                Order Number
                            </th>
                            <th scope="col" class="px-6 py-3 w-1/4">
                                Customer Name
                            </th>
                            <th scope="col" class="px-6 py-3 w-1/4">
                                Shipping Date
                            </th>
                            <th scope="col" class="px-6 py-3 w-1/4">
                                Expected Delivery Date
                            </th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @if ($isShippingStaff)
                        @if ($orders->total())
                            @foreach ($orders as $order)
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        {{ $order->order_number }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $order->name }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $order->shipping_date->format('Y/m/d') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $order->expected_delivery_date->format('Y/m/d') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <form action={{ route('orders.apply', ['order' => $order]) }} method="post">
                                            @csrf
                                            <button type="submit" class="bg-yellow-400 font-medium w-fit py-2 px-4 text-center text-black">Get order</button>
                                        </form>
                                    </td>
                                </tr>     
                            @endforeach
                        @else
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <td class="px-6 py-4 text-center" colspan="4">
                                    Oops! No orders found!
                                </td>
                            </tr>     
                        @endif
                    @else
                        @if ($orders->total())
                            @foreach ($orders as $order)
                                <tr class="bg-white border-b hover:bg-gray-50 cursor-pointer" onclick="location.href='{{ route('orders.show', ['order' => $order->id]) }}'">
                                    <td class="px-6 py-4">
                                        {{ $order->order_number }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $order->name }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $order->shipping_date->format('Y/m/d') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $order->expected_delivery_date->format('Y/m/d') }}
                                    </td>
                                </tr>     
                            @endforeach
                        @else
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <td class="px-6 py-4 text-center" colspan="4">
                                    Oops! No orders found!
                                </td>
                            </tr>     
                        @endif
                    @endif
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $orders->links() }}
        </div>
    </div>
</x-layout>