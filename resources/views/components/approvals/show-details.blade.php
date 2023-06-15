<div id="view-approval" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <a data-tw-dismiss="modal" href="javascript:;"> <i data-lucide="x" class="w-8 h-8 text-slate-400"></i> </a>
            <!-- BEGIN: Slide Over Header -->
            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto slide-over-title">
                    Show resource approval details
                </h2>

            </div>
            <!-- END: Slide Over Header -->
            <div class="modal-body">

                <p x-text="console.log(approval)"></p>

            </div>
            <!-- END: Slide Over Body -->
            <!-- BEGIN: Slide Over Footer -->
            <div class="modal-footer w-full flex justify-end gap-4 my-3">
                <form :action="declineRoute" method="post" class="my-form">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger px-5 w-fit spinner-dark">
                        <div class="flex gap-1">
                            <i data-lucide="thumbs-down" class="w-4 h-4 mr-1"></i>  Decline
                        </div>
                    </button>
                </form>

                <form :action="approveRoute" method="post" class="my-form">
                    @csrf
                    @method('PUT')

                    <button type="submit" class="btn btn-success text-white px-5 w-fit">
                        <div class="flex gap-1">
                            <i data-lucide="thumbs-up" class="w-4 h-4 mr-1"></i> Approve
                        </div>
                    </button>
                </form>
            </div>
            <!-- END: Slide Over Footer -->
        </div>
    </div>
</div>
