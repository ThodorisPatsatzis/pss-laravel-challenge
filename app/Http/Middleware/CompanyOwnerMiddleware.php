<?php

namespace App\Http\Middleware;

use App\Models\Company;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CompanyOwnerMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $company = $this->getCompany($request);

        if(is_null($company) || $company->user_id !== auth()->id()) {
            return abort(403);
        }

        $response = $next($request);
        return $response;
    }

    private function getCompany(Request $request): Company|null
    {
        $company = $request->route('company');
        if(is_null($company) && !is_null($request->route('id'))) {
            $company = Company::withTrashed()->find($request->route('id'));
        }
        return $company;
    }
}
