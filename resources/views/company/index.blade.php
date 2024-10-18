<x-app-layout>
    <x-slot name="header">
        <div class=" w-full flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Companies
            </h2>
            <div class="flex items-center gap-4">
                <a href="{{ route('company.create') }}">
                    <button class="py-2 px-4 rounded-sm text-white text-sm bg-blue-500 hover:bg-blue-600 ease-in-out duration-200">
                        Create Company
                    </button>
                </a>
            </div>
        </div>
    </x-slot>

    <div>
        @include('company.partials.index-filters')
        <div id="companiesIndexTable" class="flex flex-col text-xs lg:text-sm">
            {{-- Companies are loaded via ajax --}}
        </div>
    </div>
</x-app-layout>
