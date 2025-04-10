<form method="{{$method ?? 'post'}}" action="{{$action}}" {{$attributes->merge()}}>
    @csrf @method('delete')
    <x-button class="bg-red-500 border-red-500 hover:bg-transparent">{{$text ?? "Удалить"}}</x-button>
</form>
