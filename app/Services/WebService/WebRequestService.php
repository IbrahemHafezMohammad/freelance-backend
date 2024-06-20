<?php

namespace App\Services\WebService;

use Illuminate\Support\Facades\Log;

class WebRequestService
{
    private $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * @return mixed
     * handel all type of IP's
     */
    public function getIpAddress()
    {
        if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {

            // Log::info("Cloud flare ip ".$_SERVER["HTTP_CF_CONNECTING_IP"]);

            return $_SERVER["HTTP_CF_CONNECTING_IP"];
        } else {
            // Log::info("normal ip ".$this->request->ip());
            return $this->request->ip();
        }
       
    }
}
