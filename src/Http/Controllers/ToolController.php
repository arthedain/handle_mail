<?php

namespace Arthedain\HandleMail\Http\Controllers;

use Arthedain\HandleMail\Models\FailedJobs;
use Arthedain\HandleMail\Models\HandleMail;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use DB;

class ToolController
{
    public function getChartData(Request $request){
        $data = app('HandleMailModel')->where('created_at', '>=', Carbon::today()->subDays(30))->orderBy('created_at')->get();
        $data_failed = app('FailedJobsModel')->where('failed_at', '>=', Carbon::today()->subDays(30))->where('queue', 'handle-mail')->orderBy('failed_at')->get();

        $period = CarbonPeriod::create(Carbon::now()->subDays(30), Carbon::now());

        $collection = $this->sortData($data, $period, 'mails');
        $collection_failed = $this->sortData($data_failed, $period, 'failed', 'failed_at');

        $final_collection = collect();
        foreach ($collection as $item){
            foreach ($collection_failed as $failed){
                if($item['date'] == $failed['date']){
                    $item['failed'] = $failed['failed'];
                }
            }
            $final_collection->push($item);
        }

        return response()->json($final_collection->toArray());
    }

    public function sortData($data, $period, $name, $field = 'created_at'){
        $collection = collect();
        foreach ($period as $date){
            $items = $data->filter(function ($item) use($date, $field){
                return $item->$field->isSameDay($date);
            });

            $collection->push([
                'date' => Carbon::parse($date)->format('d F'),
                $name => $items->count(),
            ]);
        }
        return $collection;
    }

    public function getMails(){
        $mail = app('HandleMailModel')->orderBy('id', 'desc')->paginate(20);
        return response()->json($mail->toArray());
    }

    public function failed(){
        $count = app('FailedJobsModel')->where('queue', 'handle-mail')->get()->count();
        return response()->json($count);
    }

    public function delete(Request $request){
        app('HandleMailModel')->where('id', $request->id)->delete();
        return response('', 200);
    }
}
