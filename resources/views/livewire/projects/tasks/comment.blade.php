<div>
    <div  x-data="{ showReplyForm: false }">
    <div class="comment d-flex d-flex-row" id="reply">
        <i class="bi bi-person-circle fs-2 pe-1 text-secondary"></i>
        <div class="col-md-10 col-xl-10 col-sm-12">
            <div class="text-secondary">
                <strong>{{ $comment->user_name }}</strong>
                {{ \Carbon\Carbon::parse($comment->created_at)->diffForHumans() }}
                <div style="margin: 0;" class="fw-semibold">
                    {!! $comment->comment !!}
                </div>
            </div>
            @if (!$comment->parent)
                <div class="d-flex d-flex-row gap-2">
                    <p role="button" @click="showReplyForm = !showReplyForm" class="nav-link  text-decoration-none text-secondary fw-medium"><i
                            class="bi bi-reply"></i> Balas</p>
                    <p role="button" class="nav-link  text-decoration-none text-secondary fw-medium">●</p>
                    <p role="button" @click="showReply = !showReply" class="nav-link  text-decoration-none text-secondary fw-medium">Balasan <i
                            class="bi bi-chevron-down"></i></p>
                </div>
            @endif
        </div>



        {{-- <a href=""><i class="bi bi-hand-thumbs-up-fill"></i></a> --}}
        <div class=" action col-md-4 col-xl-4 col-sm-12 align-self-center fw-medium text-secondary">
            <div class="d-flex d-flex-row gap-2">
                <p role="button" class="nav-link  text-decoration-none"><i class="bi bi-pencil-square"></i>
                    Edit</p>
                <p role="button" wire:click="$dispatch('alertConfirm', {id: {{ $comment->id }}})"
                    class="nav-link text-danger text-decoration-none text-end"> <i class="bi bi-trash"></i>
                    Hapus
                </p>
            </div>
        </div>
    </div>

    <div class="p-3" x-show="showReplyForm" class="reply-form" style="display: none;">
        <form>
            @csrf
            <div>
                <div wire:ignore>
                    <div height="50px" id="editor-3">
                        <textarea wire:model='replyMessage' id="editor_1" name="" id="" cols="60" rows="2"></textarea>
                    </div>
                </div>
            </div>
        </form>
        <button class="btn btn-success btn-sm mt-2" id='submit_comment_$comment->id' type="button" wire:click='sendComment({{ $comment->id }})'><svg
                xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-send"
                viewBox="0 0 16 16">
                <path
                    d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576zm6.787-8.201L1.591 6.602l4.339 2.76z" />
            </svg> send</button>
        <button class="btn btn-success btn-sm mt-2" id='cancel_comment' type="button"
            wire:click='cancelComment'>cancel</button>
        <div wire:loading wire:target="sendComment">
            Saving post...
        </div>
    </div>
</div>
    <script>
        function initializeQuillEditors() {
    document.querySelectorAll('reply').forEach((editor) => {
        if (!editor.quill) {
            const quill = new Quill(editor, { theme: 'snow' });

            // Emit data to Livewire on change
            // quill.on('text-change', () => {
            //     const content = quill.root.innerHTML;
            //     Livewire.emit('quillContentUpdated', content);
            // });

            editor.quill = quill;
        }
    });
}

        // $(document).ready(livewire:rendered', () => {
        //     console.log("loaded");
        //     const comments = new Quill('#editor-3', {
        //         // placeholder: 'Type comment...',
        //         theme: 'snow' // or 'bubble'
        //     });
        // });
    </script>
</div>

{{-- @push('scripts') --}}
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/quill/2.0.2/quill.min.js"></script> --}}
    
{{-- @endpush --}}
