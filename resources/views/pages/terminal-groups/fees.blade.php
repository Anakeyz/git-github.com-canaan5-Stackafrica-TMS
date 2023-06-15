@extends('../layout/'.  config('view.menu-style'))

@section('title')
    Terminal Groups
@endsection

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Group "{{ $group->name }}"</li>
@endsection

@section('subcontent')
    @livewire('fees-table', ['groupId' => $group->id])
@endsection

@push('script')
    @vite('resources/js/pages/fees.js')
@endpush
