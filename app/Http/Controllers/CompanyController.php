<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Models\Company;
use App\Models\Sector;
use App\Services\CompanyService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;

class CompanyController extends Controller
{
    protected CompanyService $companyService;

    // Inject the CompanyService in the controller
    public function __construct(CompanyService $companyService)
    {
        $this->companyService = $companyService;
    }

    public function index(Request $request): View|JsonResponse
    {
        if ($request->ajax()) {
            return response()->json(['html' => $this->prepareAjaxResponseAsHtml($request)]);
        }


        return view('company.index', $this->prepareIndexFilterOptions());
    }

    private function prepareAjaxResponseAsHtml(Request $request): string
    {
        $filters = $this->getFiltersFromRequest($request);
        $companies = $this->companyService->getCompanies($filters);
        return view('company.partials.index-companies-table', compact('companies'))->render();
    }

    private function prepareIndexFilterOptions(): array
    {
        return [
            'sectorsAsSelectOptions' => $this->getSectorsAsSelectOptions(),
            'employeeRangesAsSelectOptions' => $this->getEmployeeRangesAsSelectOptions()
        ];
    }

    private function getFiltersFromRequest(Request $request): array
    {
        $searchPhrase = $request->get('sea');
        $sectors = $request->get('scts');
        $employeeRange = $request->get('emp');
        $showTrashed = $request->get('trashed');

        $filters = [];

        if ($searchPhrase) {
            $filters['searchPhrase'] = $searchPhrase;
        }

        if (!is_null($sectors)) {
            $filters['sectors'] = json_decode(urldecode($sectors), true);
        }

        if (!is_null($employeeRange)) {
            if (str_contains($employeeRange, '-')) {
                $filters['employeeRange'] = explode('-', $employeeRange);
            } else {
                $filters['employeeRange'] = 1001;
            }
        }

        if ($showTrashed) {
            $filters['showTrashed'] = $showTrashed;
        }

        return $filters;
    }

    private function getSectorsAsSelectOptions(): array
    {
        return Sector::all()->pluck('name', 'id')->toArray();
    }

    private function getEmployeeRangesAsSelectOptions(): array
    {
        return [
            '1-10' => '1-10',
            '11-50' => '11-50',
            '51-250' => '51-250',
            '251-1000' => '251-1000',
            '1000+' => '1000+'
        ];
    }

    public function create(): View
    {
        $sectorsAsSelectOptions = $this->getSectorsAsSelectOptions();
        return view('company.create', compact(['sectorsAsSelectOptions']));
    }

    public function store(StoreCompanyRequest $request): RedirectResponse
    {
        $this->companyService->store($request);

        return redirect('/companies')->with('success', 'Company was created successfully.');
    }

    public function edit(Company $company): View
    {
        $sectorsAsSelectOptions = $this->getSectorsAsSelectOptions();
        return view('company.edit', compact(['company', 'sectorsAsSelectOptions']));
    }

    public function update(UpdateCompanyRequest $request, Company $company): RedirectResponse
    {
        $this->companyService->update($request, $company);

        return redirect('/companies')->with('success', 'Company was updated successfully.');
    }

    public function delete(Company $company): RedirectResponse
    {
        if (!$this->companyService->isOwnedByUser($company)) {
            return redirect('/companies')->with('error', 'Unauthorized Action.');
        }

        $this->companyService->delete($company);

        return redirect('/companies')->with('success', 'Company was deleted successfully.');
    }

    public function restore($id): RedirectResponse
    {
        $company = Company::withTrashed()->find($id);
        if (is_null($company) || !$this->companyService->isOwnedByUser($company)) {
            return redirect('/companies')->with('error', 'Unauthorized Action.');
        }

        $this->companyService->restore($company);

        return redirect('/companies')->with('success', 'Company was restored successfully.');
    }

    public function forceDelete($id): RedirectResponse
    {
        $company = Company::withTrashed()->find($id);
        if (is_null($company) || !$this->companyService->isOwnedByUser($company)) {
            return redirect('/companies')->with('error', 'Unauthorized Action.');
        }

        $this->companyService->forceDelete($company);

        return redirect('/companies')->with('success', 'Company was permanently deleted successfully.');
    }
}
