<select name="{{$name}}"
        id="{{$name}}"
    {{$attributes->merge(['class' => 'border-2 border-white px-4 py-2 rounded-md text-white bg-black'])}}>
    @foreach($options as $option)
        <option value="{{$option->value}}">{{$option->name}}</option>
    @endforeach
</select>
