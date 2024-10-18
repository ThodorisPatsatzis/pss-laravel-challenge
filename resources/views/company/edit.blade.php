@php

    @endphp

<x-app-layout>
    <x-slot name="header">
        <div class=" w-full flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Company ({{ $company->id }})
            </h2>
            <div class="flex items-center gap-4">
                <a href="{{ route('companies.index') }}">
                    <button class="py-2 px-4 text-white rounded-sm text-sm bg-gray-500 hover:bg-gray-600 ease-in-out duration-200">
                        Go Back
                    </button>
                </a>
            </div>
        </div>
    </x-slot>

    <form action="{{ route('company.update', ['company' => $company]) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="bg-white mx-auto w-[400px] flex flex-col gap-4 items-center p-8 rounded-lg mt-8">
            <h2 class="text-lg font-semibold">Edit Company</h2>
            <div class="formFieldWrapper w-full">
                <x-input-label value="Name"/>
                <x-text-input name="name" :value="old('name', $company->name)" required/>
                @error('name')
                    <x-input-error :messages="[$message]" />
                @enderror
            </div>
            <div class="formFieldWrapper w-full">
                <x-input-label value="Address"/>
                <x-text-input name="address" :value="old('address', $company->address)" required/>
                @error('address')
                    <x-input-error :messages="[$message]" />
                @enderror
            </div>
            <div class="formFieldWrapper w-full">
                <x-input-label value="Website"/>
                <x-text-input name="website" :value="old('website', $company->website)" required/>
                @error('website')
                    <x-input-error :messages="[$message]" />
                @enderror
            </div>
            <div class="formFieldWrapper w-full">
                <x-input-label value="Email"/>
                <x-text-input name="email" :value="old('email', $company->email)" required/>
                @error('email')
                    <x-input-error :messages="[$message]" />
                @enderror
            </div>
            <div class="formFieldWrapper w-full">
                <x-input-label value="Number of Employees"/>
                <input type="number" name="number_of_employees" value="{{ old('number_of_employees', $company->number_of_employees) }}" required class="w-full border-gray-300 focus:ring-blue-500 focus:border-blue-500 rounded-md"/>
                @error('number_of_employees')
                    <x-input-error :messages="[$message]" />
                @enderror
            </div>
            <div class="formFieldWrapper w-full" x-data="{ sectorValue: '{{ $company->sector_id }}' }">
                <x-input-label value="Section"/>
                <input type="text" name="sector_id" x-model="sectorValue" value="{{ $company->sector_id }}" hidden />
                <x-select name="sector_id" placeholder="Select a Section" selected="sectorValue" :selectedLabel="data_get($sectorsAsSelectOptions, $company->sector_id)" :options="$sectorsAsSelectOptions" />
                @error('sector_id')
                    <x-input-error :messages="[$message]" />
                @enderror
            </div>
            <button type="submit" class="w-full py-2 rounded-sm bg-blue-500 hover:bg-blue-600 text-white ease-in-out duration-200">
                Submit
            </button>
        </div>
    </form>


</x-app-layout>
