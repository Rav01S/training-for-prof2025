<div class="inputBx flex flex-col gap-4">
    <label for="{{$name}}">{{$label}}</label>

    @if($type==="select")
        @if(isset($options) && count($options) === 0)
            <p>Нет вариантов выбора! Пожалуйста, создайте их сначала</p>
        @else
            <x-forms.select
                type="{{$type}}"
                name="{{$name}}"
                required="{{$required ?? false}}"
                {{$attributes->merge()}}
                :options="$options"
            />
        @endif
    @else
        <x-forms.input
            type="{{$type}}"
            name="{{$name}}"
            placeholder="{{$label}}"
            required="{{$required ?? false}}"
            {{$attributes->merge()}}
        />
    @endif

    @error($name)
    <p class="form__error text-red-500 text-sm">{{$message}}</p>
    @enderror
</div>
