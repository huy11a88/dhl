@php
    $color = $orderStatusProcessing->is($status) ? 'red' : ($orderStatusShipped->is($status) ? 'blue' : 'green');
@endphp
<span class="hidden bg-blue-500"></span>
<span class="w-[100px] text-white bg-{{ $color }}-500 px-2 py-1 rounded-md text-center">{{ $orderStatus[$status] }}</span>