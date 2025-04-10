
@if(count($options) === 0)
    <p class="form__error text-red-500 text-sm">Нет вариантов выбора, пожалуйста заполните соответсвующую таблицу</p>
@else
<select
    name="{{$name}}"
    id="{{$name}}"
    required="{{$required ?? false}}"

    {{$attributes->merge(['class' => 'border-2 border-white rounded-md px-4 py-2 text-white bg-black'])}}
>
    @foreach($options as $option)
        <option value="{{$option->value}}">{{$option->name}}</option>
    @endforeach
</select>
@endif
