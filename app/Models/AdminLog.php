<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Services\WebService\WebRequestService;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AdminLog extends Model
{
    use HasFactory;
    protected $with = ['user:id,name,user_name'];

    protected $fillable = [
        'change',
        'ip',
        'actor_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'actor_id');
    }

    // custom function

    public static function createLog($change)
    {
        $web_request_service = new WebRequestService(request());

        AdminLog::create([
            'change' => $change,
            'ip' => $web_request_service->getIpAddress(),
            'actor_id' => auth()->id()
        ]);
    }
}
