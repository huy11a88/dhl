<x-layout title="Customer Service">
    <div class="my-[50px]">
        <div class="shadow">
            <div class="grid grid-cols-4 h-full">
                <div class="border">
                    <p class="p-3 text-center">Chat Support</p>
                    <div class="border-t h-[550px] overflow-y-scroll flex flex-col gap-4 p-3">
                        @foreach ($users as $user)
                            <div id="room-{{ $user->id }}" class="flex gap-3 cursor-pointer" data-user-id="{{ $user->id }}" data-user-name="{{ $user->name }}" >
                                <div class="flex justify-center items-center rounded-full text-white bg-yellow-500 w-10 h-10 font-medium">{{ $user->avatar }}</div>
                                <div class="flex flex-col grow">
                                    {{ $user->name }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="border col-span-3">
                    <div class="p-3">
                        <p id="chat-name" class="text-center">Customer</p>
                    </div>
                    <div id="chat-box" class="border-t h-[550px]" data-user-id="{{ auth()->id() }}" data-room-user-id="">
                        <div class="h-full flex flex-col rounded-xl">
                            <div id="chat-box-content" class="flex flex-col gap-5 bg-white grow overflow-y-scroll px-3 py-5"></div>
                            <div class="relative py-2 border-t">
                                <input id="chat-message" type="text" class="w-full border-none border-transparent focus:border-transparent focus:ring-0" name="chat-message" placeholder="Type a message..." />
                                <div class="absolute right-4 bottom-4 bg-white px-2 text-gray-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>