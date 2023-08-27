<x-layout title="Order not found">
    <div class="flex justify-center items-center min-h-[400px]">
        <div class="flex px-[50px] flex-col gap-5 py-5 bg-gray-50 rounded-md w-fit">
            <p class="text-2xl text-center">Order not found!</p>
            <img src={{ Vite::asset('resources/images/oops.png') }}>
            <a href={{ route('home') }} class="bg-yellow-400 font-bold p-2 w-full mb-2 text-center" type="button">Go home</a>
        </div>
    </div>
</x-layout>