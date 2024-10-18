<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Sector;
use App\Services\CompanyService;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    protected $companyService;

    // Inject the CompanyService in the controller
    public function __construct(CompanyService $companyService)
    {
        $this->companyService = $companyService;
    }

    public function index(Request $request)
    {
        if($request->ajax()) {
            return response()->json(['html' => $this->prepareAjaxResponseAsHtml($request)]);
        }

        $companies = collect();
        $sectorsAsSelectOptions = $this->getSectorsAsSelectOptions();
        $employeeRangesAsSelectOptions = $this->getEmployeeRangesAsSelectOptions();

        return view('company.index', compact(['companies', 'sectorsAsSelectOptions', 'employeeRangesAsSelectOptions']));
    }

    private function prepareAjaxResponseAsHtml(Request $request)
    {
        $filters = $this->getFiltersFromRequest($request);
        $companies = $this->companyService->getCompanies($filters);
        return view('company.partials.index-companies-table', compact('companies'))->render();
    }

    private function getFiltersFromRequest(Request $request)
    {
        $searchPhrase = $request->get('sea');
        $sectors = $request->get('scts');
        $employeeRange = $request->get('emp');
        $showTrashed = $request->get('trashed');

        $filters = [];

        if($searchPhrase) {
            $filters['searchPhrase'] = $searchPhrase;
        }

        if(!is_null($sectors)) {
            $filters['sectors'] = json_decode(urldecode($sectors), true);
        }

        if(!is_null($employeeRange)) {
            if(str_contains($employeeRange, '-')) {
                $filters['employeeRange'] = explode('-', $employeeRange);
            }
            else {
                $filters['employeeRange'] = 1001;
            }
        }

        if($showTrashed) {
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

    public function create()
    {
        $sectorsAsSelectOptions = $this->getSectorsAsSelectOptions();
        return view('company.create', compact(['sectorsAsSelectOptions']));
    }

    public function store(Request $request)
    {
        return redirect('/companies');
    }

    public function edit(Company $company)
    {
        $sectorsAsSelectOptions = $this->getSectorsAsSelectOptions();
        return view('company.edit', compact(['company', 'sectorsAsSelectOptions']));
    }

    public function update(Company $company)
    {
        return redirect('/companies');
    }

    public function delete(Company $company)
    {
        if($company->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized Action'], 403);
        }

        $company->delete();

        return redirect('/companies');
    }

    public function restore($id): \Illuminate\Foundation\Application|\Illuminate\Http\JsonResponse|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {
        $company = Company::withTrashed()->find($id);
        if(is_null($company) || $company->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized Action'], 403);
        }

        $company->restore();

        return redirect('/companies');
    }

    public function forceDelete($id)
    {
        $company = Company::withTrashed()->find($id);
        if(is_null($company) || $company->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized Action'], 403);
        }

        $company->forceDelete();

        return redirect('/companies');
    }
}
