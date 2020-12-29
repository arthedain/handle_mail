<?php

namespace Arthedain\HandleMail\Services;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Collection;
use Stevebauman\Location\Location;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class ChartService
{
    protected Location $location;

    public function __construct(Location $location)
    {
        $this->location = $location;
    }

    public function sortData(EloquentCollection $data, CarbonPeriod $period, string $name, string $field = 'created_at'): Collection
    {
        $collection = collect();
        foreach ($period as $date) {
            $items = $data->filter(function ($item) use ($date, $field) {
                return $item->{$field}->isSameDay($date);
            });

            $collection->push([
                'date' => Carbon::parse($date),
                'value' => $items->count(),
            ]);
        }

        return $collection;
    }

//    public function mapData(EloquentCollection $collection): Collection
//    {
//        $data = collect();
//
//        foreach ($collection as $item) {
//            if (isset($item->ip_info) && $item->ip_info) {
//                $element = collect($item->ip_info);
//            } else {
//                $element = $this->location->get($item->ip);
//            }
//
//            if ($element) {
//                $element = $element->toArray();
//                $element['id'] = $item->id;
//                $element['created_at'] = Carbon::parse($item->created_at)->toDateTimeString();
//                $data->push($element);
//            }
//        }
//
//        return $data;
//    }
}
