@if($companies->count())
    <div class="categoriesTableHeader font-semibold grid grid-cols-12 px-4 mb-2">
        <div>ID</div>
        <div class="col-span-2">NAME</div>
        <div class="col-span-3">CONTACT INFO</div>
        <div class="col-span-2">SECTOR</div>
        <div class="col-span-2"># EMPLOYEES</div>
        <div class="col-span-2"></div>
    </div>
    @foreach($companies as $company)
        <div class="company grid grid-cols-12 bg-white p-4 mb-1 rounded-md overflow-auto">
            <div class="flex items-center">{{ $company->id }}</div>
            <div class="flex items-center col-span-2 font-semibold">{{ $company->name }}</div>
            <div class="col-span-3 flex flex-col">
                <span>{{ $company->address }}</span>
                <span>{{ $company->website }}</span>
                <span>{{ $company->email }}</span>
            </div>
            <div class="flex items-center col-span-2">{{ $company->sector->name }}</div>
            <div class="flex items-center col-span-2">{{ $company->number_of_employees }}</div>
            <div class="flex items-center gap-4 col-span-2">
                @if(is_null($company->deleted_at))
                    <a href="{{ route('company.edit', ['company' => $company]) }}">
                        <button
                            class="text-white text-sm p-1 bg-emerald-500 hover:bg-emerald-600 ease-in-out duration-200 min-w-[80px] rounded-sm">
                            Edit
                        </button>
                    </a>
                    <form action="{{ route('company.delete', ['company' => $company ]) }}" method="POST">
                        @csrf
                        <button type="submit"
                                class="text-white text-sm p-1 bg-red-500 hover:bg-red-600 ease-in-out duration-200 min-w-[80px] rounded-sm">
                            Delete
                        </button>
                    </form>
                @else
                    <form action="{{ route('company.restore', ['id' => $company->id ]) }}" method="POST">
                        @csrf
                        <button
                            class="text-white text-sm p-1 bg-emerald-500 hover:bg-emerald-600 ease-in-out duration-200 min-w-[80px] rounded-sm">
                            Restore
                        </button>
                    </form>
                    <form action="{{ route('company.force-delete', ['id' => $company->id ]) }}" method="POST">
                        @csrf
                        <button
                            class="text-white text-sm p-1 bg-red-500 hover:bg-red-600 ease-in-out duration-200 min-w-[120px] rounded-sm">
                            Force Delete
                        </button>
                    </form>
                @endif
            </div>
        </div>
    @endforeach
@else
    <h3 class="text-lg font-semibold text-center">No Results</h3>
@endif
