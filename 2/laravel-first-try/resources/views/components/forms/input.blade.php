<input id="{{$name}}"
       name="{{$name}}"
       placeholder="{{$placeholder}}"
       type="{{$type}}"
       @if($required) required="true" @endif
    {{$attributes->merge(['class' => 'border-2 border-white rounded-md px-4 py-2 text-white bg-black'])}}
/>
