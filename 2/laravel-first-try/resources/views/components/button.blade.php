@if ($isLink === true)
    <a href="{{$link}}" {{$attributes->merge(['class' => 'px-4 py-2 border-2 border-white rounded-md inline-block text-white'])}}>
        {{$slot}}
    </a>
@else
<button {{$attributes->merge(['class' => 'px-4 py-2 border-2 border-white rounded-md text-white'])}}>
    {{$slot}}
</button>
@endif
