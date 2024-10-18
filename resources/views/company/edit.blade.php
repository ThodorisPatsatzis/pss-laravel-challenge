@php

    @endphp

<x-app-layout>
    <x-slot name="header">
        <div class=" w-full flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Company ({{ $company->id }})
            </h2>
        </div>
    </x-slot>


    <form action="{{ route('company.update', ['company' => $company]) }}" method="POST">
        @csrf
        <div class="bg-white mx-auto w-[400px] flex flex-col gap-4 items-center p-8 rounded-lg mt-8">
            <h2 class="text-lg font-semibold">Edit Company</h2>
            <div class="w-full">
                <x-input-label value="Name"/>
                <x-text-input name="name" :value="$company->name"/>
                @error('name')
                    <x-input-error :messages="[$message]" />
                @enderror
            </div>
            <div class="w-full">
                <x-input-label value="Address"/>
                <x-text-input name="address" :value="$company->address"/>
                @error('address')
                    <x-input-error :messages="[$message]" />
                @enderror
            </div>
            <div class="w-full">
                <x-input-label value="Website"/>
                <x-text-input name="website" :value="$company->website"/>
                @error('website')
                    <x-input-error :messages="[$message]" />
                @enderror
            </div>
            <div class="w-full">
                <x-input-label value="Email"/>
                <x-text-input name="email" :value="$company->email"/>
                @error('email')
                    <x-input-error :messages="[$message]" />
                @enderror
            </div>
            <div class="w-full">
                <x-input-label value="Number of Employees"/>
                <input type="number" name="number_of_employees" value="{{ $company->number_of_employees }}" class="w-full border-gray-300 focus:ring-blue-500 focus:border-blue-500 rounded-md"/>
                @error('number_of_employees')
                    <x-input-error :messages="[$message]" />
                @enderror
            </div>
            <div class="w-full" x-data="{ sectorValue: '{{ $company->sector_id }}' }">
                <x-input-label value="Section"/>
                <input type="text" x-model="sectorValue" value="{{ $company->sector_id }}" hidden />
                <x-select name="sector" placeholder="Select a Section" selected="sectorValue" :selectedLabel="data_get($sectorsAsSelectOptions, $company->sector_id)" :options="$sectorsAsSelectOptions" />
                @error('sector')
                    <x-input-error :messages="[$message]" />
                @enderror
            </div>
            <button type="submit" class="w-full py-2 rounded-sm bg-blue-500 hover:bg-blue-600 text-white ease-in-out duration-200">
                Submit
            </button>
        </div>
    </form>


</x-app-layout>
