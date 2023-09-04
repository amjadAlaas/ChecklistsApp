<x-app-layout>
    <ul class="links flex justify-start items-center mb-4 flex-wrap">
        <li class="my-2"><a href="{{ route('checklists.show', $user->checklist[0]->id . '?req=all') }}"
                class="border-1 border-purple-500 text-purple-500 rounded py-1 px-3 mx-1 hover:bg-purple-500 hover:text-white ">All</a>
        </li>
        <li class="my-2"><a href="{{ route('checklists.show', $user->checklist[0]->id . '?req=today') }}"
                class="border-1 border-purple-500 text-purple-500 rounded py-1 px-3 mx-1 hover:bg-purple-500 hover:text-white ">Today</a>
        </li>
        <li class="my-2"><a href="{{ route('checklists.show', $user->checklist[0]->id . '?req=tomorrow') }}"
                class="border-1 border-purple-500 text-purple-500 rounded py-1 px-3 mx-1 hover:bg-purple-500 hover:text-white ">Tomorrow</a>
        </li>
        <li class="my-2"><a href="{{ route('checklists.show', $user->checklist[0]->id . '?req=thisweek') }}"
                class="border-1 border-purple-500 text-purple-500 rounded py-1 px-3 mx-1 hover:bg-purple-500 hover:text-white ">This
                Week</a></li>
        <li class="my-2"><a href="{{ route('checklists.show', $user->checklist[0]->id . '?req=thismonth') }}"
                class="border-1 border-purple-500 text-purple-500 rounded py-1 px-3 mx-1 hover:bg-purple-500 hover:text-white ">This
                Month</a></li>
    </ul>
    <x-primary-button name="header">
        <a href="{{ route('tasks.create') }}" class="create-task">create new task <i class="fa fa-plus-circle"></i></a>
    </x-primary-button>
    <div class="create-task-content">

    </div>
    <table class="table w-3/4 m-auto tasks-table">
        <thead>
            <tr>
                <th class="w-1/3">Title</th>
                <th>Date</th>
                <th class="text-right">Operation</th>
            </tr>
        </thead>
        <tbody>
            {{-- {{$user->checklist}} --}}
            @foreach ($user->checklist as $checklist)
                @foreach ($checklist->task as $task)
                    <tr>
                        <td class="flex items-center">
                            <form action="{{ route('tasks.checked', $task->id) }}" method="post"
                                class="check-form px-0 mx-0">
                                @csrf
                                @method('PATCH')
                                <input type="submit" data-task-id={{ $task->id }}
                                    class="check-submit {{ $task->status == 1 ? 'bg-purple-500 ' : '' }}rounded mx-1 w-5 h-5 text-white border-1 border-purple-500"
                                    value="">
                            </form>
                            <span
                                class="task {{ $task->status == 1 ? 'line-through' : '' }}">{{ $task->title }}</span>
                        </td>
                        <td>{{ $task->date }}</td>
                        <td class="operation flex items-center justify-end">
                            <a href="{{ route('tasks.edit', $task->id) }}"
                                class="edit border-1 border-purple-500 rounded text-purple-500 hover:bg-purple-500 hover:text-white px-2 mx-1">edit</a>
                            <form action="{{ route('tasks.destroy', $task->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <input type="submit" value="delete" data-delete={{ $task->id }}
                                    class="delete-task-btn border-1 border-red-500 rounded text-red-500 hover:bg-red-500 hover:text-white px-2 mx-1" />
                            </form>
                        </td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
</x-app-layout>
<script>
    $(document).ready(function() {
        $('.delete-task-btn').on("click", function(e) {
            e.preventDefault();
            var taskId = $(this).data('delete');
            var url = "/tasks/" + taskId;
            $.ajax({
                url: url,
                method: 'delete',
                data: {
                    _token: '{{ csrf_token() }}',
                    _method: 'DELETE'
                },
                success: function(response) {
                    // Handle the success response
                    console.log('Task deleted successfully');
                },
                error: function(xhr, status, error) {
                    // Handle the error response
                    console.log('Error checking task:', error);
                }
            });
            $(this).parent().parent().parent().remove();

        });
        $('.create-task').on('click', function(e) {
            e.preventDefault();
            $.ajax({
                method: 'GET',
                url: "{{ route('tasks.create') }}",
                success: function(data, status, xhr) {
                    // Update the desired element with the retrieved data
                    var taskForm = $(data).find('.task-form');
                    $('.create-task-content').html(taskForm);
                },
                error: function(xhr, status, error) {
                    // Handle any errors that occur during the AJAX request
                    console.log(xhr.responseText);
                }
            });
        });
        $('.check-submit').each(function() {
            $(this).on('click', function(event) {
                event.preventDefault();

                // Toggle the 'bg-purple-500' class on the clicked element
                $(this).toggleClass('bg-purple-500');
                $(this).parent().siblings().toggleClass('line-through');
                // Get the task ID from the data attribute
                var taskId = $(this).data('task-id');
                var url = `/tasks-checked/${taskId}`;

                // Make the AJAX request
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        _method: 'PATCH'
                    },
                    success: function(response) {
                        // Handle the success response
                        // console.log('Task checked successfully');
                    },
                    error: function(xhr, status, error) {
                        // Handle the error response
                        console.log('Error checking task:', error);
                    }
                });
            });
        });
        var dots = document.querySelectorAll('.dots');
        var dropdownMenu = document.querySelector('.dropdown-menu-list');
        dots.forEach(dot => {
            dot.addEventListener("click", function(e) {
                dropdownMenu.classList.toggle('show');
            });
        });
    });
</script>
