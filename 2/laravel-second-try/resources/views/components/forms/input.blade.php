<input
    type="{{$type}}"
    id="{{$name}}"
    name="{{$name}}"
    placeholder="{{$placeholder ?? ""}}"
    {{$attributes->merge(['class' => 'border-2 border-white px-4 py-2 rounded-md text-white bg-black'])}}
/>
