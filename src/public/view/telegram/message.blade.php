@foreach($data as $key => $item)
@if($key == 'data')
@foreach($item as $k => $i)
{{ __($k) .' : '. $i }}
@endforeach
@else
{{ __($key) .' : '. $item }}
@endif
@endforeach
