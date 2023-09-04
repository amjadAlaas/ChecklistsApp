<x-app-layout>
    <x-slot name="header">
        {{ __('Checklists') }}
    </x-slot>
    <a href="{{ route('checklists.create') }}"
        class="text-purple-500 rounded-lg border-box border-double border-1 border-purple-500 w-fit hover:text-white hover:bg-purple-500 ease-in-out duration-200 p-2 m-2">Create
        New Checklist <i class="fa fa-plus-circle"></i></a>
    <table class="text-center table  m-auto checklist-table">
        <thead>
            <tr>
                <th width="60%" class="text-left">Title</th>
                <th>Operation</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($checklists as $checklist)
                <tr>
                    <td width="60%" class="text-left">{{ $checklist->title }}</td>
                    <td class="flex">
                        <a class="border-green-500 border-1 text-green-800 p-2 mr-2 rounded-tl-lg rounded-br-lg hover:bg-green-500 hover:border-white hover:text-white ease-in-out duration-200"
                            href="{{ route('checklists.show', $checklist->id) }}">show</a>
                        <a class="border-purple-500 border-1 text-purple-800 p-2 mr-2 rounded-tl-lg rounded-br-lg hover:bg-purple-500 hover:border-white hover:text-white ease-in-out duration-200"
                            href="{{ route('checklists.edit', $checklist->id) }}">Edit</a>
                        <form action="{{ route('checklists.destroy', $checklist->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <input type="submit"
                                class="border-red-500 border-1 text-red-800 p-2 mr-2 rounded-tl-lg rounded-br-lg hover:bg-red-500 hover:border-white hover:text-white ease-in-out duration-200"
                                value="Delete">
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</x-app-layout>
