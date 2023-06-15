<div class="mt-4 bg-white px-5 py-3">
    <p class="font-semibold">Showing list of all wallets</p>
    <div >
        <div class="intro-y overflow-auto mt-8 sm:mt-0">
            <table class="table table-report table-auto table-hover sm:mt-2">
                <thead>
                <tr class="bg-gray-200">
                    <th class="whitespace-nowrap">Name</th>
                    <th class="whitespace-nowrap">Role</th>
                    <th class="whitespace-nowrap">Account Number</th>
                    <th class="whitespace-nowrap">Balance</th>
{{--                    <th class="whitespace-nowrap">Income</th>--}}
                    <th class="whitespace-nowrap">Status</th>
                    <th class="whitespace-nowrap">Date Created</th>
                </tr>
                </thead>

                <tbody>
                @foreach ($wallets as $wallet)
                    <tr class="intro-x">
                        <td class="">
                            <a href="{{ route('users.show', $wallet->owner->id) }}"
                               class="tooltip text-blue-600"
                               title="{{ $wallet->owner->email }}"
                            >
                                {{ ucwords($wallet->owner->name) }}
                            </a>
                        </td>

                        <td class=""><x-badge>{{ ucwords($wallet->owner->roleName) }}</x-badge></td>

                        <td class="">{{ $wallet->account_number }}</td>

                        <td class="text-blue-600">@money($wallet->balance)</td>

{{--                        <td class="text-success">@money($wallet->income)</td>--}}

                        <td class=""><livewire:status-toggle-badge :model="$wallet" wire:key="wallet-{{$wallet->id}}" /></td>

                        <td class="">{{ pDate($wallet->created_at) }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div>
            {{ $wallets->links() }}
        </div>
    </div>
</div>
