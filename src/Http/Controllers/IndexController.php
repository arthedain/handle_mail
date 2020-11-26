<?php

namespace Arthedain\HandleMail\Http\Controllers;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Arthedain\HandleMail\Models\FailedJobs;
use Arthedain\HandleMail\Models\HandleMail;
use Arthedain\HandleMail\Services\MailService;
use Arthedain\HandleMail\Services\ChartService;

class IndexController
{
    protected MailService $mailService;

    public function __construct(MailService $mailService)
    {
        $this->mailService = $mailService;
    }

    public function getChartData(Request $request, ChartService $chartService)
    {
        $data = HandleMail::orderBy('id', 'asc')->get();

        $period = CarbonPeriod::create($data->first()->created_at, Carbon::now());

        $collection = $chartService->sortData($data, $period, 'mails');

        return response()->json([
            'chart' => $collection->toArray(),
        ]);
    }

    //TODO: refactor filter
    public function getMails(Request $request)
    {
        $mails = HandleMail::orderBy('id', 'desc');

        if ($request->get('from')) {
            $mails = $mails->from($request->get('from'));
        }

        if ($request->get('to')) {
            $mails = $mails->to($request->get('to'));
        }
        if ($request->get('search')) {
            $mails = $mails->search($request->get('search'));
        }

        $mails = $mails->paginate(20);

        return response()->json([
            'mails' => $mails->toArray(),
        ]);
    }

    public function failed()
    {
        $count = FailedJobs::where('queue', 'handle-mail')->get()->count();

        return response()->json([
            'count' => $count,
        ]);
    }

    public function delete(Request $request, string $id)
    {
        if ($this->mailService->delete($id)) {
            return response('', 200);
        }

        return response('', 500);
    }
}
