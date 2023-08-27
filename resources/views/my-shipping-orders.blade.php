<x-layout title="My Shipping Orders">
    <div class="py-[50px] px-[50px]">
        <h1 class="text-3xl">My Shipping Order</h1>
        @if ($orders->count() === 0)
            <p class="text-center mt-5">Oops! There is no order!</p>
        @endif
        @foreach ($orders as $index => $order)
            <div class="mt-5 flex flex-col gap-1">
                <div class="flex border shadow cursor-pointer toggle select-none">
                    <div class="w-[300px] bg-yellow-400 p-3 font-medium">{{ ++$index }}. {{ $order->order_number }}</div>
                    <div class="grow flex gap-5 items-center flex-row-reverse px-5">
                        <svg class="angle-up w-5 h-5 text-gray-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 8">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7 7.674 1.3a.91.91 0 0 0-1.348 0L1 7"></path>
                        </svg>
                        <svg class="hidden angle-down w-5 h-5 text-gray-700 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 8">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 5.326 5.7a.909.909 0 0 0 1.348 0L13 1"></path>
                        </svg>
                        <x-order-status-tag :status="$order->status"/>
                        <p>{{ $order->shipping_date->toFormattedDateString() }}</p>
                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path fill="currentColor" d="M6 1a1 1 0 0 0-2 0h2ZM4 4a1 1 0 0 0 2 0H4Zm7-3a1 1 0 1 0-2 0h2ZM9 4a1 1 0 1 0 2 0H9Zm7-3a1 1 0 1 0-2 0h2Zm-2 3a1 1 0 1 0 2 0h-2ZM1 6a1 1 0 0 0 0 2V6Zm18 2a1 1 0 1 0 0-2v2ZM5 11v-1H4v1h1Zm0 .01H4v1h1v-1Zm.01 0v1h1v-1h-1Zm0-.01h1v-1h-1v1ZM10 11v-1H9v1h1Zm0 .01H9v1h1v-1Zm.01 0v1h1v-1h-1Zm0-.01h1v-1h-1v1ZM10 15v-1H9v1h1Zm0 .01H9v1h1v-1Zm.01 0v1h1v-1h-1Zm0-.01h1v-1h-1v1ZM15 15v-1h-1v1h1Zm0 .01h-1v1h1v-1Zm.01 0v1h1v-1h-1Zm0-.01h1v-1h-1v1ZM15 11v-1h-1v1h1Zm0 .01h-1v1h1v-1Zm.01 0v1h1v-1h-1Zm0-.01h1v-1h-1v1ZM5 15v-1H4v1h1Zm0 .01H4v1h1v-1Zm.01 0v1h1v-1h-1Zm0-.01h1v-1h-1v1ZM2 4h16V2H2v2Zm16 0h2a2 2 0 0 0-2-2v2Zm0 0v14h2V4h-2Zm0 14v2a2 2 0 0 0 2-2h-2Zm0 0H2v2h16v-2ZM2 18H0a2 2 0 0 0 2 2v-2Zm0 0V4H0v14h2ZM2 4V2a2 2 0 0 0-2 2h2Zm2-3v3h2V1H4Zm5 0v3h2V1H9Zm5 0v3h2V1h-2ZM1 8h18V6H1v2Zm3 3v.01h2V11H4Zm1 1.01h.01v-2H5v2Zm1.01-1V11h-2v.01h2Zm-1-1.01H5v2h.01v-2ZM9 11v.01h2V11H9Zm1 1.01h.01v-2H10v2Zm1.01-1V11h-2v.01h2Zm-1-1.01H10v2h.01v-2ZM9 15v.01h2V15H9Zm1 1.01h.01v-2H10v2Zm1.01-1V15h-2v.01h2Zm-1-1.01H10v2h.01v-2ZM14 15v.01h2V15h-2Zm1 1.01h.01v-2H15v2Zm1.01-1V15h-2v.01h2Zm-1-1.01H15v2h.01v-2ZM14 11v.01h2V11h-2Zm1 1.01h.01v-2H15v2Zm1.01-1V11h-2v.01h2Zm-1-1.01H15v2h.01v-2ZM4 15v.01h2V15H4Zm1 1.01h.01v-2H5v2Zm1.01-1V15h-2v.01h2Zm-1-1.01H5v2h.01v-2Z"></path>
                        </svg>
                    </div>
                </div>
                <div class="py-5 px-7 border shadow content hidden">
                    <div class="grid grid-cols-2 gap-2">
                        <p>Customer Name: {{ $order->user->name }}</p>
                        <p>Expected Delivery Date: {{ $order->expected_delivery_date->format('Y/m/d') }}</p>
                        <p>Recipient Address: {{ $order->recipient_address }}</p>
                        <p>Shipping Address: {{ $order->shipping_address }}</p>
                        @if ($orderStatusDelivered->is($order->status))
                            <p>Status: {{  $orderStatus[$order->status] }}</p>
                        @else
                        <form id="update-order-status" action={{ route('orders.update-status') }} method="post">
                            @csrf
                            <input type="hidden" name="order-id" value={{ $order->id }}>
                            <div class="flex items-end gap-3">
                                <label for="order-status" class="block">
                                    <span class="block">Status</span>
                                    <select name="order-status" id="order-status">
                                        @foreach ($order->status_selectbox as $status => $value)
                                            <option value={{ $status }}>{{  $value }}</option>
                                        @endforeach
                                    </select>
                                </label>
                                <button type="submit" class="bg-green-500/60 font-medium w-fit py-2 px-4 text-white h-fit" disabled>Update</button>
                            </div>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</x-layout>