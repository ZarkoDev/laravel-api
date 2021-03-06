<?php

namespace App\Http\Services;

use App\Http\Traits\ErrorTrait;
use Illuminate\Support\Facades\Http;

class ClearbitApiService extends BaseApiService
{
    use ErrorTrait;

    const DOWNLOAD_COMPANY_DETAILS_ENDPOINT = 'https://company-stream.clearbit.com/v1/companies/domain/';
    CONST ERROR_MESSAGE_DEFAULT = 'Missing error message';

    private function getApiKey()
    {
        return env('CLEARBIT_API_KEY');
    }

    public function downloadCompanyDetails(string $domain)
    {
        $this->response = Http::withToken($this->getApiKey())
            ->get(self::DOWNLOAD_COMPANY_DETAILS_ENDPOINT . $domain);

        $this->responseBody = $this->response->collect();
    }

    public function getResponseErrorMessage()
    {
        if (!$this->isResponseFailed()) {
            return null;
        }

        if (!isset($this->responseBody['error']['message'])) {
            return self::ERROR_MESSAGE_DEFAULT;
        }

        return $this->responseBody['error']['message'];
    }
}
