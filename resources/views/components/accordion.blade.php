<div class="text-center border border-gray-400">
    <button onclick="toggleAccordionContent(this)" class="block bg-gray-200 text-center w-full py-4">{{ $name
    }}</button>

    <div class="hidden accordion-content">
        {{ $slot }}
    </div>
</div>
