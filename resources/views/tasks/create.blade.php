<x-app-layout>
    <x-slot name="header">
        {{ __('Create Tasks') }}
    </x-slot>
    <ul class="errors-container">
    </ul>
    <div class="success-container">
    </div>
    <form action="{{ route('tasks.store') }}" method="post" class="w-3/4 m-auto task-form">
        @csrf
        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
            <div class="sm:col-span-12">
                <label for="title" class="block text-md font-medium leading-6 text-gray-900">Title</label>
                <div class="mt-2">
                    <input type="text" name="title" id="title" autocomplete="given-name"
                        class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                </div>
            </div>
            <div class="sm:col-span-12 mt-4">
                <label for="date" class="block text-md font-medium leading-6 text-gray-900">date</label>
                <div class="mt-2">
                    <input type="date" name="date" id="date" autocomplete="given-name"
                        class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                </div>
            </div>
            <div class="sm:col-span-12 mt-4">
                <label for="checklist" class="block text-sm font-medium leading-6 text-gray-900">checklists</label>
                <div class="mt-2 mb-2">
                    <select id="checklist" name="checklist" autocomplete="checklist"
                        class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        <option selected>select checklist</option>
                        @foreach ($checklists as $checklist)
                            <option value="{{ $checklist->id }}">{{ $checklist->title }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <input type="submit" value="Add Task" class="add-task-btn bg-purple-500 text-white py-2 rounded">
        </div>
    </form>
    <script>
        $(document).ready(function() {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            $(document).on("click", ".add-task-btn", function(e) {
                e.preventDefault();
                let title = $("#title").val();
                let date = $("#date").val();
                let checklist = $("#checklist").val();
                $.ajax({
                    method: 'POST',
                    url: "{{ route('tasks.store') }}",
                    headers: {
                        'X-CSRF-TOKEN': csrfToken // Include the CSRF token in the request header
                    },
                    data: {
                        title: title,
                        date: date,
                        checklist: checklist,
                    },
                    success: function(res) {
                        // Update the desired element with the retrieved data
                        if (res.status == "success") {
                            $(".success-container").append(
                                `<span class="block bg-green-400 text-white my-2 p-2 rounded">added successfuly</span>`
                            );
                        }
                    },
                    error: function(err) {
                        // Handle any errors that occur during the AJAX request
                        let error = err.responseJSON;
                        $.each(error.errors, function(index, value) {
                            console.log(value);
                            $(".errors-container").append(
                                `<li class='bg-red-500 text-white my-2 p-2 rounded'>${value}</li>`
                                );
                        });
                    }
                });
            });
        });
    </script>
</x-app-layout>
