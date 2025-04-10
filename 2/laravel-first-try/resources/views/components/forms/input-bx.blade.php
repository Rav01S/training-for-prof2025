<div class="inputBx flex flex-col gap-2">
    <label class="text-white" for="{{$name}}">{{$label}}</label>


    @if($type === "select")
        <x-forms.select
            name="{{$name}}"
            required="{{$required ?? false}}"
            :options="$options"
            {{$attributes->merge()}}
        />
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
