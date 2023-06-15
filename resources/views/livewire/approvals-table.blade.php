<div x-data="{approval: {}, approveRoute: null, declineRoute: null}">

    <div class="sm:mb-3 flex flex-col-reverse sm:flex-row justify-between sm:items-center mt-5 intro-y">
        <p class="font-semibold">Showing list of all pending approvals for actions</p>
    </div>

    <!-- BEGIN: HTML Table Data -->
    <div class="intro-y box p-5 mt-5" x-data>
        <div class="overflow-x-auto scrollbar-hidden">

            <table class="table table-report table-auto table-hover sm:mt-2">
                <thead>
                <tr class="bg-gray-200">
                    <th scope="col">#</th>

                    <th scope="col">Resource</th>

                    <th scope="col" class="text-center">Action</th>

                    <th scope="col">Performed By</th>

                    <th scope="col" class="text-center">Date</th>

                    <th class="text-center whitespace-nowrap">
                        <span class="flex justify-center">
                            <i data-lucide="settings" class="w-5 h-5"></i>
                        </span>
                    </th>
                </tr>
                </thead>

                <tbody>
                @foreach ($approvals as $approval)
                    <tr class="intro-x">
                        <td class="w-56">{{ $loop->iteration }}</td>

                        <td class="w-56">{{ $approval->resource }}</td>

                        <td class=""><x-badge :value="$approval->action" /></td>

                        <td class="whitespace-nowrap">{{ $approval->author->name ?? '' }}</td>

                        <td class="whitespace-nowrap">{{ $approval->created_at->toDayDateTimeString() }}</td>

                        <td class="table-report__action w-56">
                            <div class="flex justify-around items-center">
                                {{--<button class="flex items-center mr-3 text-blue-600"
                                        data-tw-toggle="modal" data-tw-target="#view-approval"
                                        @click="approval = @js($approval); approveRoute = '{{ route('approvals.update', $approval) }}'; declineRoute = '{{route('approvals.destroy', $approval) }}'"
                                >
                                    <i data-lucide="eye" class="w-4 h-4 mr-1"></i> View
                                </button>--}}

                                <form action="{{ route('approvals.update', $approval) }}" method="post" class="my-form">
                                    @csrf
                                    @method('PUT')

                                    <button type="submit" title="Approve"
                                            class="flex items-center text-success cursor-pointer tooltip spinner-dark"
                                    >
                                        <i data-lucide="thumbs-up" class="w-4 h-4 mr-1"></i>
                                    </button>
                                </form>

                                <form action="{{ route('approvals.destroy', $approval) }}" method="post" class="my-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" title="Decline"
                                            class="flex items-center text-red-600 cursor-pointer tooltip spinner-dark"
                                    >
                                        <i data-lucide="thumbs-down" class="w-4 h-4 mr-1"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>

                @endforeach
                </tbody>
            </table>
        </div>

        <div>
            {{ $approvals->links() }}
        </div>
    </div>
    <!-- END: HTML Table Data -->

    {{--<section class="mt-8 bg-white px-5 py-3">
        <div class="sm:mb-3 flex flex-col-reverse sm:flex-row justify-between sm:items-center intro-y">
            <p class="font-semibold">Showing list of all pending approvals for actions</p>
        </div>
        <div>
            <div class="intro-y overflow-auto lg:overflow-visible">
                <table class="table table-report table-auto table-hover sm:mt-2">
                    <thead>
                    <tr class="bg-gray-200">
                        <th scope="col">#</th>

                        <th scope="col">Resource</th>

                        <th scope="col" class="text-center">Action</th>

                        <th scope="col">Performed By</th>

                        <th scope="col" class="text-center">Date</th>

                        <th class="text-center whitespace-nowrap">
                                <span class="flex justify-center">
                                    <i data-lucide="settings" class="w-5 h-5"></i>
                                </span>
                        </th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach ($approvals as $approval)
                        <tr class="intro-x">
                            <td class="w-56">{{ $loop->iteration }}</td>

                            <td class="w-56">{{ $approval->resource }}</td>

                            <td class=""><x-badge :value="$approval->action" /></td>

                            <td class="whitespace-nowrap">{{ $approval->author->name }}</td>

                            <td class="whitespace-nowrap"><span class="text-dark">{{ $approval->created_at->toDayDateTimeString() }}</span></td>

                            <td class="table-report__action w-48">
                                <div class="flex justify-around items-center">
                                    <button data-tw-toggle="modal" data-tw-target="#view-changes"
                                       title="View changes"
                                       class="flex items-center text-info cursor-pointer tooltip"
                                    >
                                        <i data-lucide="eye" class="w-4 h-4 mr-1"></i>
                                    </button>

                                    <form action="{{ route('approvals.update', $approval) }}" method="post" class="my-form">
                                        @csrf
                                        @method('PUT')

                                        <button type="submit" title="Approve" @click="approval = @js($approval)"
                                                class="flex items-center text-success cursor-pointer tooltip spinner-dark"

                                        >
                                            <i data-lucide="thumbs-up" class="w-4 h-4 mr-1"></i>
                                        </button>
                                    </form>

                                    <form action="{{ route('approvals.destroy', $approval) }}" method="post" class="my-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Decline"
                                                class="flex items-center text-red-600 cursor-pointer tooltip spinner-dark"
                                        >
                                            <i data-lucide="thumbs-down" class="w-4 h-4 mr-1"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <div>
                    {{ $approvals->links() }}
                </div>
            </div>
        </div>
    </section>--}}

    <x-approvals.show-details />

</div>
