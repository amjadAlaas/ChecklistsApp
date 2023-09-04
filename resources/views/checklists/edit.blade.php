<x-app-layout>
    <x-slot name="header">
        {{ __('Create Checklist') }}
    </x-slot>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('checklists.update', $checklist->id) }}" method="post" class="checklist-form">
        @csrf
        @method('PUT')
        <input type="text" name="title" value="{{ $checklist->title }}">
        <x-primary-button>
            <input type="submit" value="submit">
        </x-primary-button>
    </form>



</x-app-layout>
