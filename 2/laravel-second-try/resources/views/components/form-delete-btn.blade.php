<form
    action="{{$action}}"
    method="post"
    class="inline-block"
>
    @csrf @method('delete')
    <x-button class="text-white bg-red-500 border-red-500">Удалить</x-button>
</form>
