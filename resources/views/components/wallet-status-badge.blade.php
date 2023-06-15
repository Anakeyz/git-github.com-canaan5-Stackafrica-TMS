@props(['wallet'])
<x-badge :color=" statusColor($wallet->status)"
         class="flex w-fit justify-between pr-1 text-xs"
>
    <span>{{ $wallet->status }}</span>

    <form method="POST" action="{{ route('wallets.update-status', $wallet->uwid) }}" class="pl-2 inline">

        @csrf
        @if($wallet->is_active)
            <a href="javascript:;"
               onclick="event.preventDefault(); this.closest('form').submit();"
               class="flex items-center tooltip"
               title="Suspend"
            >
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 mr-1"><rect x="1" y="5" width="22" height="14" rx="7" ry="7"></rect><circle cx="8" cy="12" r="3"></circle></svg>
            </a>
        @else
            <a href="javascript:;"
               onclick="event.preventDefault(); this.closest('form').submit();"
               class="flex items-center tooltip"
               title="Activate"
            >
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 mr-1"><rect x="1" y="5" width="22" height="14" rx="7" ry="7"></rect><circle cx="16" cy="12" r="3"></circle></svg>
            </a>
        @endif
    </form>
</x-badge>
