@extends('../layout/'.  config('view.menu-style'))

@section('title')
    KYC Documents
@endsection

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('users.show', ['user' => $user->id]) }}">Agent</a></li>
    <li class="breadcrumb-item active" aria-current="page">KYC Documents</li>
@endsection

@section('subcontent')
    <section>
        <div class="intro-y flex items-center mt-8">
            <h2 class="text-lg font-medium mr-auto">
                KYC Documents
            </h2>
        </div>
    </section>

    <section class="mt-8">
        <p class="py-2 my-2">
            <strong>{{ $user->name }}</strong> |
            <a href="mailto:{{ $user->email }}" class="italic text-info hover:opacity-70">{{$user->email}}</a> |
            {{ $user->phone }}
        </p>
        <div class="grid md:grid-cols-3 grid-cols-4 gap-5">
            <div class="col-span-4 sm:col-span-2 md:col-span-1">
                <div class="box p-5 mb-2">

                    <form method="post" action="{{ route('users.update', $user->id) }}" class="my-form">
                        @csrf
                        @method('PUT')

                        <div class="form-inline mt-3">
                            <label for="bvn" class="form-label">BVN</label>
                            <div class="w-full">
                                <input id="bvn" type="text" class="form-control"
                                       placeholder="Agent's bank verification number"
                                       name="bvn" value="{{old('bvn') ?? $user->bvn }}"
                                >
                                <x-input-error input-name="bvn" />
                            </div>
                        </div>
                        <div class="form-inline mt-6">
                            <label for="nin" class="form-label">NIN</label>
                            <div class="w-full">
                                <input id="nin" type="text" class="form-control"
                                       placeholder="Agent's National identification number"
                                       name="nin" value="{{ old('nin') ?? $user->nin }}"
                                >
                                <x-input-error input-name="nin" />
                            </div>
                        </div>

                        <div class="flex justify-end mt-5 pt-4 border-t">
                            <button type="submit" class="btn btn-primary w-24">Submit</button>
                        </div>
                    </form>
                </div>

                <div class="box p-5 mt-2">
                    <h5 class="font-semibold mb-3 flex items-center">
                        <i data-lucide="file-plus"></i>
                        <span class="ml-2">Upload New Document.</span>
                    </h5>
                    <form method="post" class="my-form" action="{{ route('users.kyc-docs.store', $user->id) }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-inline mt-4">
                            <label for="name" class="pr-2">Title</label>
                            <div class="w-full">
                                <input id="name" type="text" class="form-control"
                                       placeholder="Enter the title of the document"
                                       name="name" value="{{old('name')}}"
                                       required
                                >
                                <x-input-error input-name="name" />
                            </div>
                        </div>
                        <div class="mt-6">
                            <div class="w-full">
                                <input type="file" id="file" name="file" class="dropify"
                                       data-allowed-file-extensions="pdf png jpg jpeg doc docx"
                                       data-max-file-size="5M" required
                                />
                            </div>
                        </div>

                        <div class="flex justify-end mt-3 pt-4 border-t">
                            <button type="submit" class="btn btn-primary w-24">Submit</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="grid grid-cols-10 gap-5 col-span-4 sm:col-span-2">
                @if($user->kycDocs->count() > 0)
                    @foreach($user->kycDocs as $doc)
                        <div class="intro-y col-span-6 sm:col-span-4 md:col-span-3 2xl:col-span-2">
                            <div class="file box rounded-md px-5 pt-8 pb-5 px-3 sm:px-5 relative zoom-in">

                                <a href="{{ $doc->path }}" target="_blank" class="w-3/5 file__icon file__icon--file mx-auto">
                                    <div class="file__icon__file-name">{{ strtoupper($doc->ext) }}</div>
                                </a>

                                <a href="{{ $doc->path }}" target="_blank" class="block font-medium mt-4 text-center truncate">
                                    {{ $doc->name }}
                                </a>

                                <div class="absolute top-0 right-0 mr-2 mt-3 dropdown ml-auto">
                                    <a class="dropdown-toggle w-5 h-5 block" href="javascript:;" aria-expanded="false" data-tw-toggle="dropdown"> <i data-lucide="more-vertical"></i> </a>
                                    <div class="dropdown-menu w-32">
                                        <ul class="dropdown-content">
                                            <li>
                                                <a href="" class="dropdown-item  text-info hover:opacity-70">
                                                    <i data-lucide="refresh-ccw" class="w-3 h-3 mr-2"></i> Change
                                                </a>
                                            </li>
                                            <li>
                                                <form action="{{ route('kyc-docs.destroy', $doc->id) }}" method="post" class="delete">
                                                    @csrf
                                                    @method('DELETE')
                                                    <span href="" class="dropdown-item text-danger hover:opacity-70"
                                                          onclick="this.closest('form').submit()"
                                                    >
                                                        <i data-lucide="trash" class="w-3 h-3 mr-2"></i> Delete
                                                    </span>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                @else
                    <div class="col-span-12 text-center mt-20 text-lg text-slate-500">No document has been uploaded yet!</div>
                @endif
            </div>
        </div>
    </section>

@endsection

