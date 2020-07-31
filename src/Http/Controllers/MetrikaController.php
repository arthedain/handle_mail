<?php


namespace Arthedain\HandleMail\Http\Controllers;


use Carbon\Carbon;
use Stevebauman\Location\Location;

class MetrikaController
{
    public function getMapData(){
        $mails = app('HandleMailModel')->orderBy('id', 'desc')->get(['id', 'data', 'ip', 'created_at']);
        $location = new Location();
        $data = collect();

        foreach ($mails as $item){
            if(isset($item->data['ip_info'])){
                $element = collect($item->data['ip_info']);
            }else{
                $element = $location->get($item->ip);
            }

            if ($element){
                $element = $element->toArray();
                $element['id'] = $item->id;
                $element['created_at'] = Carbon::parse($item->created_at)->toDateTimeString();
                $data->push($element);
            }
        }

        return response()->json($data->toArray());
    }
}
