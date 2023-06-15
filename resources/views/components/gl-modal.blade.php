@props(['gl'])

<x-modal :modal-id="'modal'. $gl->id" :modal-title="'Fund ' . $gl->service->name . ' General Ledger'" :is-large="false">
    <form action="{{ route('general-ledger.update', $gl->id) }}" method="post" class="col-span-12">
        @csrf

        <div class="flex justify-start items-center gap-4">
            <label for="amount" class="form-label">Amount</label>
            <input type="text" class="form-control" placeholder="0.00"
                   aria-label="amount for general ledger" name="amount" value="{{ old('amount') }}" required
            />
            <x-input-error :input-name="$error = 'amount'" />
        </div>
        <div class="text-right mt-7 pt-3 border-t">
            <button type="submit" class="btn btn-primary w-24 py-1">Fund</button>
        </div>
    </form>
</x-modal>
