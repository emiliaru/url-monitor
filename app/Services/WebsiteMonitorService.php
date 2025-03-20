<?php

namespace App\Services;

use App\Models\Website;
use App\Models\WebsiteCheck;
use Illuminate\Support\Facades\Http;
use Exception;

class WebsiteMonitorService
{
    public function checkWebsite(Website $website)
    {
        $startTime = microtime(true);
        
        try {
            $response = Http::timeout(30)->get($website->url);
            $endTime = microtime(true);
            
            $check = new WebsiteCheck([
                'website_id' => $website->id,
                'status_code' => $response->status(),
                'response_time' => round($endTime - $startTime, 3),
                'is_up' => $response->successful(),
                'headers' => $response->headers(),
                'checked_at' => now()
            ]);
            
            $check->save();
            
            $website->update([
                'last_check_at' => now()
            ]);
            
            return $check;
        } catch (Exception $e) {
            $check = new WebsiteCheck([
                'website_id' => $website->id,
                'is_up' => false,
                'error_message' => $e->getMessage(),
                'checked_at' => now()
            ]);
            
            $check->save();
            
            $website->update([
                'last_check_at' => now()
            ]);
            
            return $check;
        }
    }
}
