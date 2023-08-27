<x-layout title="Order detail">
    <div class="flex justify-center items-center min-h-[400px] my-8" data-order-id={{$order->id}}>
        <div class="flex px-[50px] flex-col gap-5 py-10 bg-gray-50 rounded-md w-[50%]">
            <p class="text-xl underline">Order detail #{{ $order->id }}:</p>
            <div class="grid grid-cols-5">
                <div class="col-span-2 flex flex-col gap-2">
                    <p>Customer Name:</p>
                    <p>Order Number:</p>
                    <p>Recipient Address:</p>
                    <p>Shipping Address:</p>
                    <p>Shipping Date:</p>
                    <p>Expected Delivery Date:</p>
                    <p>Shipping Status:</p>
                    <p>Created Date:</p>
                </div>
                <div class="col-span-3 flex flex-col gap-2">
                    <p>{{ $order->name }}</p>
                    <p>{{ $order->order_number }}</p>
                    <p>{{ $order->recipient_address }}</p>
                    <p>{{ $order->shipping_address }}</p>
                    <p>{{ $order->shipping_date->format('Y/m/d') }}</p>
                    <p>{{ $order->expected_delivery_date->format('Y/m/d') }}</p>
                    <p>{{ $orderStatus[$order->status] }}</p>
                    <p>{{ $order->created_at->format('Y/m/d H:i:s') }}</p>
                </div>
            </div>
            <div class="flex justify-between">
                <a href={{ route('home') }} class="bg-yellow-400 font-medium w-fit py-2 px-4 text-center" type="button">Back to orders</a>
                @if (auth()->id() == $order->user_id)
                    <div class="flex gap-3">
                        @if ($orderStatusPending->is($order->status))
                            <a href={{ route('orders.edit', ['order' => $order->id]) }} class="bg-yellow-400 font-medium w-fit py-2 px-4 text-center" type="button">Edit</a>
                            <x-popup-modal modal-id="delete-order">
                                <x-slot:button>
                                    <button data-modal-target="delete-order" class="bg-red-500 font-medium w-fit py-2 px-4 text-center text-white">
                                        Delete
                                    </button>
                                </x-slot:button>
                                <x-slot:content>
                                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                    </svg>
                                    <h3 class="mb-5 text-lg font-normal text-gray-500">Are you sure you want to delete order #{{ $order->id }}?</h3>
                                </x-slot:content>
                                <x-slot:submit>
                                    <form action={{ route('orders.destroy', ['order' => $order->id]) }} method="post" class="inline-block">
                                        @method('DELETE')
                                        @csrf
                                        <button data-modal-hide="delete-order" class="text-white bg-red-500 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                                            Yes, I'm sure
                                        </button>
                                    </form>
                                </x-slot:submit>
                            </x-popup-modal>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
    @if (auth()->id() == $order->user_id && $orderStatusDelivered->is($order->status))
        <form id="add-review">
            <input type="hidden" name="order_id" value={{ $order->id }}>
            <div class="flex flex-col gap-4 my-[30px] py-[40px] px-[10%]">
                    <h1 class="text-2xl border-b">Reviews</h1>
                    <div class="flex items-end gap-2">
                        <span>Rating:</span>
                        <x-rating/>
                    </div>
                    <div class="flex flex-col gap-2">
                        <textarea name="review" id="review" rows="3" class="w-full block" placeholder="Leave a review..."></textarea>
                        <button class="bg-yellow-400/60 font-medium w-fit py-2 px-5 text-center self-end" disabled>Post</button>
                    </div>
            </div>
        </form>
    @endif
    <div id="comment-list" class="flex flex-col gap-4 my-[30px] pb-[40px] px-[10%]">
        <p class="underline"><span id="total-comment">0</span> reviews</p>
    </div>
</x-layout>