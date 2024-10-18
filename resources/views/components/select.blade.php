@props([
    'name' => null,
    'multiple' => false,
    'options' => [],
    'selected' => null,
    'selectedLabel' => null,
    'placeholder' => null,
    'widthClass' => 'w-full'
])

@if(is_array($options) && count($options))
    <div
        x-data="{
            open: false,
            placeholder: '{{ $placeholder }}',
            selectedOptionsWithLabels: $persist({}).as('{{ $name }}SelectedOptionsWithLabels'),
            selectedLabel: $persist('{{!is_null($selectedLabel) ? $selectedLabel : '' }}').as('{{ $name }}SelectedLabel'),
            multiple: {{ $multiple ? 'true' : 'false' }},
            isSelected(value) {
                if(this.multiple) {
                    return {{ $selected }}.includes(value)
                }
                else {
                    return {{ $selected }} == value
                }
            },
            isEmpty() {
                if(this.multiple) {
                    return !{{ $selected }}.length
                }
                else {
                    return {{ $selected }} === null
                }
            },
            selectOption(value, label) {
                if(this.isSelected(value)) {
                    this.deselectOption(value)
                    return
                }

                if(this.multiple) {
                    {{ $selected }}.push(value)
                    this.selectedOptionsWithLabels[value] = label
                }
                else {
                    {{ $selected }} = value
                    this.selectedLabel = label
                    this.open = false
                }
            },
            deselectOption(value = null) {
                if(this.multiple) {
                    const index = {{ $selected }}.indexOf(value)
                    if(index !== -1) {
                        {{ $selected }}.splice(index, 1)
                        delete this.selectedOptionsWithLabels[value]
                    }
                }
                else {
                    {{ $selected }} = null
                    this.selectedLabel = null
                    this.open = false
                }
            },
            resetSelect() {
                if(this.isEmpty()) {
                    return
                }
                if(this.multiple) {
                    {{ $selected }} = []
                    this.selectedOptionsWithLabels = []
                }
                else {
                    {{ $selected }} = null,
                    this.selectedOptionsWithLabels = null
                }
            },
        }"
        class="relative {{ $widthClass }} inline-block text-sm"
    >
        <button @click="open = !open"
                class="w-full bg-white border border-gray-300 rounded-lg px-4 py-2 text-left text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 overflow-x-auto flex justify-between">
            <template x-if="isEmpty()">
                <span x-text="placeholder"></span>
            </template>
            <template x-if="multiple">
                <div class="flex gap-1">
                    <template x-for="(label, value) in selectedOptionsWithLabels">
                        <div class="bg-gray-200 px-1 rounded-sm flex items-center gap-1">
                            <span x-text="selectedOptionsWithLabels[value]" class="cursor-default"></span>
                            <span class="text-blue-500 hover:text-blue-600 ease-in-out duration-200 cursor-pointer" @click.stop="deselectOption(value)">X</span>
                        </div>
                    </template>
                </div>
            </template>
            <template x-if="!multiple && !isEmpty()">
                <div class="flex items-center gap-2">
                    <span x-text="selectedLabel"></span>
                    <span class="text-blue-500 hover:text-blue-600 ease-in-out duration-200 cursor-pointer" @click.stop="deselectOption()">X</span>
                </div>
            </template>
            <svg class="w-5 h-5 inline-block float-right text-gray-500" fill="none" stroke="currentColor"
                 viewBox="0 0 24 24"
                 xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M19 9l-7 7-7-7"></path>
            </svg>
        </button>

        <ul x-cloak x-show="open" @click.away="open = false"
            class="absolute w-full bg-white border border-gray-300 mt-1 rounded-lg shadow-lg z-10 max-h-48 overflow-y-auto">
            @foreach($options as $value => $label)
                <li @click="selectOption('{{ $value }}', '{{ $label }}')"
                    :class="{ 'bg-blue-500 text-white': isSelected('{{ $value }}'), 'hover:bg-gray-100': !isSelected('{{ $value }}') }"
                    class="px-4 py-2 cursor-pointer  flex items-center">
                    {{ $label }}
                </li>
            @endforeach
        </ul>

    </div>
@endif
