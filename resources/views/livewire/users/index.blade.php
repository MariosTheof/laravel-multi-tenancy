
<div>
    <table class="w-full leading-normal divide-y divide-gray-200">
        <thead class="bg-gray-50">
        <tr>
            <th>User Name</th>
            <th>Email</th>

        </tr>
        </thead>
        <tbody>
        @foreach ($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>

                <td>
{{--                    <x-secondary-button wire:click="edit({{ $user->id }})">Edit</x-secondary-button>--}}
                    <x-secondary-button wire:click="delete({{ $user->id }})">Delete</x-secondary-button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>


</div>
