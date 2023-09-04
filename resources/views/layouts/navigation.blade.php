<aside class="z-20 hidden w-64 overflow-y-auto bg-white md:block flex-shrink-0">
    <div class="py-4">
        <canvas id="taskChart"></canvas>
        <script>
            // Retrieve the percentages from your Laravel code
            var tasksWithStatus0 = {{ $tasksWithStatus0 }};
            var tasksWithStatus1 = {{ $tasksWithStatus1 }};

            // Create a doughnut chart
            var ctx = document.getElementById('taskChart').getContext('2d');

            var taskChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['processing', 'Done'],
                    datasets: [{
                        data: [tasksWithStatus0, tasksWithStatus1],
                        backgroundColor: ['rgb(240 82 82)', 'rgb(144 97 249)'],
                        hoverBackgroundColor: ['rgb(240 82 82)', 'rgb(144 97 249)'],
                    }]
                },
                options: {
                    responsive: true
                }
            });
            ctx.lineWidth = 20;
        </script>
        <a class="ml-6 text-lg font-bold" href="{{ route('checklists.index') }}">
            Checklist
        </a>
        <ul class="mt-6">
            @foreach ($checklists as $checklist)
                <li class="relative px-6 py-3 text-purple-500 hover:bg-purple-500 hover:text-white">
                    <x-nav-link href="{{ route('checklists.show', $checklist->id) }}" :active="request()->url() === route('checklists.show', ['checklist' => $checklist->id])">
                        {{ __($checklist->title) }}
                    </x-nav-link>
                </li>
            @endforeach
        </ul>

    </div>
</aside>
