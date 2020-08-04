<?php

namespace Arthedain\HandleMail\Http\Controllers;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;

class ToolController
{
    public function getChartData(Request $request){
        $data = app('HandleMailModel')->orderBy('created_at')->get();

        $period = CarbonPeriod::create($data->first()->created_at, Carbon::now());

        $collection = $this->sortData($data, $period, 'mails');

        return response()->json($collection->toArray());
    }

    public function sortData($data, $period, $name, $field = 'created_at'){
        $collection = collect();
        foreach ($period as $date){
            $items = $data->filter(function ($item) use($date, $field){
                return $item->$field->isSameDay($date);
            });

            $collection->push([
                'date' => Carbon::parse($date),
                'value' => $items->count(),
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
