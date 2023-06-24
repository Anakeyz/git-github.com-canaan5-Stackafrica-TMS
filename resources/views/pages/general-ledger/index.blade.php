@extends('../layout/'.  config('view.menu-style'))

@section('title')
    General Ledger
@endsection

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('general-ledger.show') }}">Main General Ledger</a></li>
    <li class="breadcrumb-item active" aria-current="page">Others</li>
@endsection

@section('subcontent')
    <section>
        <div class="intro-y flex items-center mt-8">
            <h2 class="text-lg font-medium mr-auto">
                General Ledgers
            </h2>
        </div>
    </section>

    <section class="mt-6">
        <div class="flex justify-end m-0 p-0"> <i data-lucide="chevrons-right" class="w-4 h-4 inline"></i></div>
        <div class="flex overflow-x-scroll mt-1 pb-10 hide-scroll-bar">
            <div class="flex flex-nowrap">
                @foreach($gls as $gl)
                    <div class="report-box zoom-in inline-block px-2">
                        <div class="box p-5 w-80">
                            <div class="flex gap-3">
                                <a class="mr-auto" href="{{ route('general-ledger.show', ['service' => $gl->service->slug]) }}">
                                    <div class="text-dark text-opacity-70 text-xs flex font-medium items-center leading-3">
                                        <span class="pr-2 truncate">{{ $gl->service->name }} Balance</span>
                                        <i data-lucide="alert-circle" class="w-4 h-4"></i>
                                    </div>
                                    <div class="text-dark relative text-xl font-medium leading-5 pl-4 mt-3.5">
                                        @money($gl->balance)
                                    </div>
                                </a>
                                <span class="flex items-center justify-center w-12 h-12 rounded-full bg-info bg-opacity-20 hover:bg-opacity-30 text-info cursor-pointer"
                                      data-tw-toggle="modal" data-tw-target="#modal{{$gl->id}}"
                                >
                                    <i data-lucide="plus"></i>
                                </span>
                            </div>
                        </div>
                    </div>

                    <x-gl-modal :gl="$gl" />
                @endforeach
            </div>
        </div>
    </section>

    <section>
        <livewire:gl-table />
    </section>
@endsection
