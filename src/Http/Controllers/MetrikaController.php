<?php

namespace Arthedain\HandleMail\Http\Controllers;

use Arthedain\HandleMail\Models\HandleMail;
use Arthedain\HandleMail\Services\ChartService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MetrikaController
{
    public function getMapData(Request $request, ChartService $chartService)
    {
        $mails = HandleMail::orderBy('id', 'desc');

        if ($request->from) {
            $mails = $mails->from(Carbon::parse($request->from));
        }

        if ($request->to) {
            $mails = $mails->to(Carbon::parse($request->to));
        }

        $mails = $mails->get(['id', 'data', 'ip', 'created_at']);

        $data = $chartService->mapData($mails);

        return response()->json($data->toArray());
    }
}
