<x-app-layout>
    <x-slot name="header">
        {{ __("Tasks for " . $user->checklist[0]->title) }}
    </x-slot>
    <ul class="links flex justify-start items-center mb-4 flex-wrap">
        <li class="my-2"><a href="{{route('checklists.show', $user->checklist[0]->id . "?req=all")}}" class="border-1 border-purple-500 text-purple-500 rounded py-1 px-3 mx-1 hover:bg-purple-500 hover:text-white ">All</a></li>
        <li class="my-2"><a href="{{route('checklists.show', $user->checklist[0]->id . "?req=today")}}" class="border-1 border-purple-500 text-purple-500 rounded py-1 px-3 mx-1 hover:bg-purple-500 hover:text-white ">Today</a></li>
        <li class="my-2"><a href="{{route('checklists.show', $user->checklist[0]->id . "?req=tomorrow")}}" class="border-1 border-purple-500 text-purple-500 rounded py-1 px-3 mx-1 hover:bg-purple-500 hover:text-white ">Tomorrow</a></li>
        <li class="my-2"><a href="{{route('checklists.show', $user->checklist[0]->id . "?req=thisweek")}}" class="border-1 border-purple-500 text-purple-500 rounded py-1 px-3 mx-1 hover:bg-purple-500 hover:text-white ">This Week</a></li>
        <li class="my-2"><a href="{{route('checklists.show', $user->checklist[0]->id . "?req=thismonth")}}" class="border-1 border-purple-500 text-purple-500 rounded py-1 px-3 mx-1 hover:bg-purple-500 hover:text-white ">This Month</a></li>
    </ul>
    <table class="table w-3/4 mx-auto">
        <thead>
            <tr>
                <th class="">Title</th>
                <th class="">Date</th>
                <th class="text-right">Opration</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($user->checklist as $checklist)
                @foreach ($checklist->task as $task)
                    <tr>
                        <td class="flex items-center">
                            <form action="{{ route('tasks.checked', $task->id) }}" method="post"
                                class="check-form px-0 mx-0">
                                @csrf
                                @method('PATCH')
                                <input type="submit"
                                    class="{{ $task->status == 1 ? 'bg-purple-500 ' : '' }}rounded mx-1 w-5 h-5 text-white border-1 border-purple-500"
                                    value="">
                            </form>
                            <span class="{{ $task->status ==  1 ? 'line-through' : '' }}">{{ $task->title }}</span>
                        </td>
                        <td>{{ $task->date }}</td>
                        <td class="operation flex items-center justify-end">
                            <a href="{{ route('tasks.edit', $task->id) }}"
                                class="edit border-1 border-purple-500 rounded text-purple-500 hover:bg-purple-500 hover:text-white px-2 mx-1">edit</a>
                            <form action="{{ route('tasks.destroy', $task->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <input type="submit" value="delete"
                                    class="border-1 border-red-500 rounded text-red-500 hover:bg-red-500 hover:text-white px-2 mx-1" />
                            </form>
                        </td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
</x-app-layout>
