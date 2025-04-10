@if($isLink === true)
    <a
        href="{{$link}}"
        {{$attributes->merge(['class' => 'border-2 border-white text-white bg-black px-4 py-2 rounded-md inline-block'])}}
    >
        {{$slot}}
    </a>
@else
    <button
        {{$attributes->merge(['class' => 'border-2 border-white text-white bg-black px-4 py-2 rounded-md'])}}
    >
        {{$slot}}
    </button>
@endif
