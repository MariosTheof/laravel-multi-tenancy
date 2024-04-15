<div>
    <table class="w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
        <tr>
            <th>Name</th>
            <th>Info</th>
            <th>Address</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($companies as $company)
            <tr>
                <td>{{ $company->name }}</td>
                <td>{{ $company->info }}</td>
                <td>{{ $company->address }}</td>
                <td>
{{--                    <x-secondary-button wire:click="edit({{ $company->id }})">Edit</x-secondary-button>--}}
                    <x-secondary-button wire:click="delete({{ $company->id }})">Delete</x-secondary-button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
