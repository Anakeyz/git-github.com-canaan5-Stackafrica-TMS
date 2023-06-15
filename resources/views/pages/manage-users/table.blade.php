<div class="col-span-12 mt-6 bg-white px-5 py-3">
    <p class="font-semibold py-2">Showing List of {{ ucwords($name) }}</p>

    <div class="intro-y overflow-auto sm:mt-0">
        <table class="table table-report table-auto table-hover">
            <thead>
            <tr class="bg-gray-200">
                <th></th>
                <th class="whitespace-nowrap">NAME</th>
                <th class="whitespace-nowrap">EMAIL</th>
                <th class="whitespace-nowrap">PHONE</th>
                @if($showLevel)
                    <th class="whitespace-nowrap">LEVEL</th>
                @endif
                @if($showRole)
                    <th class="whitespace-nowrap">ROLE</th>
                @endif
                <th class="whitespace-nowrap">STATUS</th>
                <th class="whitespace-nowrap">DATE REGISTERED</th>

                @if($roleAction)
                    <th class="text-center whitespace-nowrap">
                    <span class="flex justify-center">
                        <i data-lucide="settings" class="w-5 h-5"></i>
                    </span>
                    </th>
                @endif
            </tr>
            </thead>
            <tbody>
            @if($users->count() > 0)
                @foreach ($users as $user)
                    <tr class="intro-x">
                        <td class="w-20">
                            <div class="flex">
                                <div class="w-10 h-10 image-fit zoom-in">
                                    <x-user-avatar :user="$user" class="rounded-full" />
                                </div>
                            </div>
                        </td>
                        <td class="whitespace-nowrap font-medium">
                            <a href="{{ route('users.show', $user->id) }}"
                               class="hover:opacity-70"
                            >
                                {{ $user->name }}
                            </a>
                        </td>

                        <td class=""><a href="mailto:{{$user->email}}">{{ $user->email }}</a></td>

                        <td class="">{{ $user->phone }}</td>

                        @if($showLevel)
                            <td><x-badge>{{ $user->kycLevel->name }}</x-badge></td>
                        @endif

                        @if($showRole)
                            <td class=""><x-badge>@nbsp($user->roleName)</x-badge></td>
                        @endif

                        <td class="">
                            <livewire:user-status-badge :user="$user" wire:key="status-badge-{{ $user->id }}"/>
                        </td>

                        <td class="">{{ pDate($user->created_at) }}</td>

                        @if(!is_null($roleAction))
                            <td class="table-report__action w-56">
                                <div class="flex justify-center items-center">
                                    <form method="POST" action="{{ route('roles.users.destroy', [$roleAction, $user]) }}" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <a href="#"
                                           onclick="event.preventDefault(); this.closest('form').submit();"
                                           class="flex items-center text-orange-600"
                                        >
                                            <i data-lucide="trash-2" class="w-4 h-4 mr-1"></i> Remove
                                        </a>
                                    </form>
                                </div>
                            </td>
                        @endif

                    </tr>
                @endforeach
            @else
                <tr><td colspan="7" class="text-center">No users available.</td></tr>
            @endif
            </tbody>
        </table>
        <div>
            {{ $users->links()}}
        </div>
    </div>
</div>
