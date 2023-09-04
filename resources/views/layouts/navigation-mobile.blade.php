<div x-show="isSideMenuOpen" x-transition:enter="transition ease-in-out duration-150" x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in-out duration-150"
    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-10 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center"></div>
<aside class="fixed inset-y-0 z-20 flex-shrink-0 w-64 mt-16 overflow-y-auto bg-white md:hidden" x-show="isSideMenuOpen"
    x-transition:enter="transition ease-in-out duration-150"
    x-transition:enter-start="opacity-0 transform -translate-x-20" x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in-out duration-150" x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0 transform -translate-x-20" @click.outside="closeSideMenu"
    @keydown.escape="closeSideMenu">
    <div class="py-4 text-gray-500 dark:text-gray-400">
        <canvas id="taskChartMobile"></canvas>
        <script>
            // Retrieve the percentages from your Laravel code
            var tasksWithStatus0 = {{ $tasksWithStatus0 }};
            var tasksWithStatus1 = {{ $tasksWithStatus1 }};

            // Create a doughnut chart
            var ctx = document.getElementById('taskChartMobile').getContext('2d');

            var taskChartMobile = new Chart(ctx, {
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
        </script>
        <a class="ml-6 text-lg font-bold text-gray-800" href="{{ route('checklists.index') }}">
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
