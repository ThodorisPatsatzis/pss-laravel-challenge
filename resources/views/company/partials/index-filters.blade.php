<div
    x-data="{
                sectionFilterValue: $persist([]),
                numberOfEmployeesFilterValue: $persist(null),
                searchValue: $persist(null),
                showOnlyTrashed: $persist(false),
                pendingResponse: false,
                previousRequestFiltersValues: $persist([]),
                watchFilterValues() {
                    $watch('sectionFilterValue', value => this.fetchChanges())
                    $watch('numberOfEmployeesFilterValue', value => this.fetchChanges())
                    $watch('searchValue', value => this.fetchChanges())
                    $watch('showOnlyTrashed', value => this.fetchChanges())
                },
                async fetchChanges() {
                    if(this.isDuplicateRequest()) {
                        console.log('Duplicate request was skipped')
                        return
                    }

                    this.pendingResponse = true
                    document.getElementById('companiesIndexTable').innerHTML = ''
                    this.updateLastRequestFiltersValues()

                    await fetch('{{ route('companies.index') }}?' + this.getQueryString(), {
                         headers: {
                            'X-Requested-With': 'XMLHttpRequest', // This is crucial for Laravel to detect AJAX
                            'Content-Type': 'application/json',
                         }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network Error');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if(data.html) {
                            document.getElementById('companiesIndexTable').innerHTML = data.html
                        }
                        this.pendingResponse = false
                    }).catch(err => {
                        console.error('Error: ', err)
                        this.pendingResponse = false
                    })
                },
                isDuplicateRequest() {
                    return  this.searchValue === this.previousRequestFiltersValues['searchValue'] &&
                            this.numberOfEmployeesFilterValue === this.previousRequestFiltersValues['numberOfEmployeesFilterValue'] &&
                            this.sectionFilterValue === this.previousRequestFiltersValues['sectionFilterValue'] &&
                            this.showOnlyTrashed === this.previousRequestFiltersValues['showOnlyTrashed']
                },
                updateLastRequestFiltersValues() {
                    this.previousRequestFiltersValues['searchValue'] = this.searchValue
                    this.previousRequestFiltersValues['numberOfEmployeesFilterValue'] = this.numberOfEmployeesFilterValue
                    this.previousRequestFiltersValues['sectionFilterValue'] = [...this.sectionFilterValue]
                    this.previousRequestFiltersValues['showOnlyTrashed'] = this.showOnlyTrashed
                },
                getQueryString() {
                    const params = new URLSearchParams()
                    if(this.searchValue) {
                        params.append('sea', this.searchValue)
                    }
                    if(this.numberOfEmployeesFilterValue) {
                        params.append('emp', this.numberOfEmployeesFilterValue)
                    }
                    if(this.sectionFilterValue.length) {
                        params.append('scts', encodeURIComponent(JSON.stringify(this.sectionFilterValue)))
                    }
                     if(this.showOnlyTrashed) {
                        params.append('trashed', this.showOnlyTrashed)
                    }
                    return params.toString()
                }
            }"
    x-init="watchFilterValues(); fetchChanges()"
>
    <div class="filtersSectionWrapper flex items-center justify-between py-4 px-8 bg-white mb-4 rounded-md">
        <div class="filtersContainer flex gap-2">
            <x-select selected="sectionFilterValue" :options="$sectorsAsSelectOptions" placeholder="Sections" multiple  persist widthClass="w-[200px]"/>
            <x-select selected="numberOfEmployeesFilterValue" :options="$employeeRangesAsSelectOptions"  placeholder="Employee Range" persist widthClass="w-[200px]"/>
        </div>
        <div class="searchBarContainer">
            <x-text-input x-model.debounce="searchValue" placeholder="Search..." />
        </div>
    </div>
    <div class="flex justify-end mb-8">
        <template x-if="!showOnlyTrashed">
            <span class="font-semibold text-sm cursor-pointer" @click="showOnlyTrashed = true" title="Click here to display deleted companies">
                Displaying only Existing Companies
            </span>
        </template>
        <template x-if="showOnlyTrashed">
            <span class="text-red-600 font-semibold text-sm cursor-pointer" @click="showOnlyTrashed = false" title="Click here to display existing companies">
                Displaying only Deleted Companies
            </span>
        </template>
    </div>

    <div class="w-full text-lg font-semibold text-center mt-8" x-show="pendingResponse">Loading...</div>
</div>
