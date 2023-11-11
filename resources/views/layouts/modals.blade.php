<div id="delete" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form class="modal-content" id="delete-form" method="post">
            @csrf
            @method('delete')
            <div class="modal-body p-0">
                <div class="p-5 text-center">
                    <i data-feather="x-circle" class="w-16 h-16 text-theme-24 mx-auto mt-3"></i>
                    <div class="fs-3xl mt-5">Are you sure?</div>
                    <div class="text-gray-600 mt-2">Do you want to delete this data? <br>This action cannot be undone.
                    </div>
                </div>
                <div class="px-5 pb-8 text-center">
                    <button type="button" data-bs-dismiss="modal"
                        class="btn btn-outline-secondary w-24 me-1">Cancel</button>
                    <button type="submit" class="btn btn-danger w-24">Delete</button>
                </div>
            </div>
        </form>
    </div>
</div> <!-- END: Modal Content -->
<div id="restore" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form class="modal-content" id="restore-form" method="post">
            @csrf
            @method('post')
            <div class="modal-body p-0">
                <div class="p-5 text-center">
                    <i class="fas fa-trash-restore w-16 h-16 text-theme-15 mx-auto mt-3"></i>
                    <div class="fs-3xl mt-5">Are you sure?</div>
                </div>
                <div class="px-5 pb-8 text-center">
                    <button type="button" data-bs-dismiss="modal"
                        class="btn btn-outline-secondary w-24 me-1">Cancel</button>
                    <button type="submit" class="btn btn-success w-24">Restore</button>
                </div>
            </div>
        </form>
    </div>
</div> <!-- END: Modal Content -->
<div class="modal fade" id="common-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" id="edit-area">

    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@stack('models')
