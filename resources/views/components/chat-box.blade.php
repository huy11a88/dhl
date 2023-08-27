<div class="fixed bottom-5 right-5 z-50">
    <div id="chat-box-icon" class="cursor-pointer">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-16 h-16 text-yellow-500">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 9.75a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375m-13.5 3.01c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.184-4.183a1.14 1.14 0 01.778-.332 48.294 48.294 0 005.83-.498c1.585-.233 2.708-1.626 2.708-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" />
        </svg>
    </div>
    <div id="chat-box" class="hidden" data-user-id="{{ auth()->id() }}">
        <div class="w-[450px] h-[600px] shadow flex flex-col rounded-xl">
            <div id="chat-box-header" class="flex justify-between items-center bg-gradient-to-r from-yellow-400 to-yellow-200 p-3 rounded-t-xl font-medium">
                <span>Live Chat Service</span>
                <button class="bg-transparent text-sm w-8 h-8 inline-flex justify-center items-center">
                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                </button>
            </div>
            <div id="chat-box-content" class="flex flex-col gap-5 bg-white grow overflow-y-scroll px-3 py-5"></div>
            <div class="relative p-2 bg-white rounded-xl">
                <input id="chat-message" type="text" class="block w-full rounded-xl border-slate-200 focus:border-slate-200 focus:ring-0" name="chat-message" placeholder="Feel free to ask" />
                <div class="absolute right-4 bottom-4 bg-white px-2 text-gray-500">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                    </svg>
                </div>
            </div>
        </div>
    </div>
</div>