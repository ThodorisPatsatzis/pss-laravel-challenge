<?php

namespace App\Services;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class CompanyService
{
    // Retrieves the Companies at the Companies index page
    public function getCompanies(array $filters = []): Collection
    {
        $companiesQuery = null;

        $this->applyFiltersToCompaniesQuery($companiesQuery, $filters);

        return $companiesQuery->get();
    }

    // Applies all filters applied by the user at the index page
    private function applyFiltersToCompaniesQuery(&$companiesQuery, $filters = [])
    {
        $user = auth()->user();

        // if the user wants to view only his "soft" deleted companies
        $showTrashed = data_get($filters, 'showTrashed', false);
        if ($showTrashed) {
            $companiesQuery = Company::onlyTrashed()->where('user_id', $user->id);
        } else {
            $companiesQuery = $user->companies();
        }

        // if the user has searched for specific Companies based on their name
        $searchPhrase = data_get($filters, 'searchPhrase');
        if ($searchPhrase) {
            $companiesQuery = $companiesQuery->where('name', 'like', '%' . $searchPhrase . '%');
        }

        // if the user wants to view Companies with specific employee ranges (e.g. 1-10, 11-50, ... , 1001+)
        $employeeRange = data_get($filters, 'employeeRange');
        if ($employeeRange) {
            if (is_array($employeeRange)) {
                $companiesQuery = $companiesQuery->whereBetween('number_of_employees', $employeeRange);
            } else {
                $companiesQuery = $companiesQuery->where('number_of_employees', '>=', $employeeRange);
            }
        }

        // if the user wants to view Companies that operate on specific sectors
        $sectors = data_get($filters, 'sectors');
        if (is_array($sectors)) {
            $companiesQuery = $companiesQuery->whereIn('sector_id', $sectors);
        }
    }

    public function store(Request $request): void
    {
        Company::create([
            'name' => $request->get('name'),
            'address' => $request->get('address'),
            'email' => $request->get('email'),
            'website' => $request->get('website'),
            'number_of_employees' => $request->get('number_of_employees'),
            'sector_id' => $request->get('sector_id'),
            'user_id' => auth()->id()
        ]);
    }

    public function update(Request $request, Company $company): void
    {
        $company->update([
            'name' => $request->get('name'),
            'address' => $request->get('address'),
            'email' => $request->get('email'),
            'website' => $request->get('website'),
            'number_of_employees' => $request->get('number_of_employees'),
            'sector_id' => $request->get('sector_id'),
            'user_id' => auth()->id()
        ]);
    }

    public function delete(Company $company): void
    {
        $company->delete();
    }

    public function restore(Company $company): void
    {
        $company->restore();
    }

    public function forceDelete(Company $company): void
    {
        $company->forceDelete();
    }

    public function isOwnedByUser(Company $company): bool
    {
        return $company->user_id === auth()->id();
    }
}
