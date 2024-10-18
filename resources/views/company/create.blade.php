@php

@endphp

<x-app-layout>
    <x-slot name="header">
        <div class=" w-full flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create Company
            </h2>
        </div>
    </x-slot>


    <form action="{{ route('company.store') }}" method="POST">
        @csrf
        <div class="bg-white mx-auto w-[400px] flex flex-col gap-4 items-center p-8 rounded-lg mt-8">
            <div>
                <x-input-label value="Name"/>
                <x-text-input/>
            </div>
            <div>
                <x-input-label value="Address"/>
                <x-text-input/>
            </div>
            <div>
                <x-input-label value="Website"/>
                <x-text-input/>
            </div>
            <div>
                <x-input-label value="Email"/>
                <x-text-input/>
            </div>
            <div>
                <x-input-label value="Number of Employees"/>
                <input type="number" class="border-gray-300 focus:ring-blue-500 focus:border-blue-500 rounded-md"/>
            </div>
            <div>
                <x-input-label value="Section"/>
                <x-select placeholder="Select a Section" :options="$sectorsAsSelectOptions" />
            </div>
            <button type="submit" class="w-full py-2 rounded-sm bg-blue-500 hover:bg-blue-600 text-white ease-in-out duration-200">
               Submit
            </button>
        </div>
    </form>


</x-app-layout>
