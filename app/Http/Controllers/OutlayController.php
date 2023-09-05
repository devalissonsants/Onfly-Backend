<?php

namespace App\Http\Controllers;

use App\Http\Requests\OutlayRequest;
use App\Models\Outlay;
use App\Services\OutlayService;
use Illuminate\Http\Request;

class OutlayController extends Controller
{
    private $outlayService;

    public function __construct(OutlayService $outlayService)
    {
        $this->outlayService = $outlayService;
    }

    public function index(Request $request)
    {
        return $this->outlayService->getOutlayAll($request->all());
    }

    public function show($id)
    {
        return $this->outlayService->getOutlayId($id);
    }

    public function store(OutlayRequest $request)
    {
        return $this->outlayService->postOutlay($request->all());
    }

    public function update(OutlayRequest $request, $id)
    {
        $this->authorize('update', Outlay::findOrFail($id));
        return $this->outlayService->putOutlay($request->all(), $id);
    }

    public function destroy($id)
    {
        $this->authorize('delete', Outlay::with('user')->findOrFail($id));
        return $this->outlayService->deleteOutlay($id);
    }
}
