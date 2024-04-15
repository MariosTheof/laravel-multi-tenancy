
<div>
    <table class="w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
        <tr>
            <th>Project Name</th>
            <th>Description</th>
            <th>Creator</th>
            <th>Company</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($projects as $project)
            <tr>
                <td>{{ $project->name }}</td>
                <td>{{ $project->description }}</td>
                <td>{{ $project->creator->name }}</td>
                <td>{{ $project->company->name }}</td>
                <td>
                <td>
{{--                    <x-secondary-button wire:click="edit({{ $project->id }})">Edit</x-secondary-button>--}}
                    <x-secondary-button wire:click="delete({{ $project->id }})">Delete</x-secondary-button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>


</div>
