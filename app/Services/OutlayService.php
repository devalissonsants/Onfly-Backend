<?php

namespace App\Services;

use App\Http\Resources\OutlayResource;
use App\Models\Outlay;
use Illuminate\Support\Facades\Cache;

class OutlayService
{
    private $outlay;
    private $outlayWith = 'user';

    public function __construct(Outlay $outlay)
    {
        $this->outlay = $outlay;
    }

    public function getOutlayAll($request)
    {
        return Cache::remember('outlay', env('TIME_CACHE', 60), function () use ($request) {
            $outlay = Utils::search($this->outlay, $request);
            return  OutlayResource::collection(Utils::pagination($outlay->with($this->outlayWith), $request));
        });
    }

    public function getOutlayId($id)
    {
        return $this->outlay->with($this->outlayWith)->findOrFail($id);
    }

    public function postOutlay($request)
    {
        Cache::forget('outlay');
        $outlay = new Outlay;
        $outlay = $outlay->create($request);
        return $this->outlay::with($this->outlayWith)->find($outlay->id);
    }

    public function putOutlay($request, $id)
    {
        Cache::forget('outlay');
        $outlay = $this->outlay->with($this->outlayWith)->findOrFail($id);
        $outlay->fill($request)->save();
        return $this->outlay::with($this->outlayWith)->find($id);
    }

    public function deleteOutlay($id)
    {
        Cache::forget('outlay');
        $this->outlay->findOrFail($id)->delete();
        return true;
    }
}
