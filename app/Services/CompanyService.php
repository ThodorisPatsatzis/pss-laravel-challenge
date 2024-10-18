<?php

namespace App\Services;

use App\Models\Company;
use Illuminate\Support\Collection;

class CompanyService
{
    public function getCompanies(array $filters = []): Collection
    {
        $user = auth()->user();

        $companiesQuery = null;

        $this->applyFiltersToCompaniesQuery($companiesQuery, $filters);

        return $companiesQuery->get();
    }

    private function applyFiltersToCompaniesQuery(&$companiesQuery, $filters = [])
    {
        $user = auth()->user();

        $showTrashed = data_get($filters, 'showTrashed', false);
        if($showTrashed) {
            $companiesQuery = Company::onlyTrashed()->where('user_id', $user->id);
        }
        else {
            $companiesQuery = $user->companies();
        }

        $searchPhrase = data_get($filters, 'searchPhrase');
        if($searchPhrase) {
            $companiesQuery = $companiesQuery->where('name', 'like', '%'.$searchPhrase.'%');
        }

        $employeeRange = data_get($filters, 'employeeRange');
        if($employeeRange) {
            if(is_array($employeeRange)) {
                $companiesQuery = $companiesQuery->whereBetween('number_of_employees', $employeeRange);
            }
            else {
                $companiesQuery = $companiesQuery->where('number_of_employees', '>=', $employeeRange);
            }
        }

        $sectors = data_get($filters, 'sectors');
        if(is_array($sectors)) {
            $companiesQuery = $companiesQuery->whereIn('sector_id', $sectors);
        }
    }
}
