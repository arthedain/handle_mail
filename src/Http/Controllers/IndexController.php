<?php

namespace Arthedain\HandleMail\Http\Controllers;

use Arthedain\HandleMail\Repositories\HandleMailRepository;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Arthedain\HandleMail\Models\FailedJobs;
use Arthedain\HandleMail\Models\HandleMail;
use Arthedain\HandleMail\Services\MailService;
use Arthedain\HandleMail\Services\ChartService;

class IndexController
{
    protected HandleMailRepository $handleMailRepository;

    public function __construct(HandleMailRepository $handleMailRepository)
    {
        $this->handleMailRepository = $handleMailRepository;
    }

    public function getChartData(Request $request, ChartService $chartService)
    {
        $data = $this->handleMailRepository->getNotSpam();

        $period = CarbonPeriod::create(Carbon::parse($data->first()->created_at)->subDay(), Carbon::now()->addDay());

        $collection = $chartService->sortData($data, $period, 'mails');

        return response()->json([
            'chart' => $collection->toArray(),
        ]);
    }

    public function getMails(Request $request)
    {
        $mails = $this->handleMailRepository->getPaginated(20, $request->get('from'), $request->get('to'), $request->get('search'));

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

    public function delete(Request $request, MailService $mailService)
    {
        if ($mailService->delete($request->id)) {
            return response('', 200);
        }

        return response('', 500);
    }
}
