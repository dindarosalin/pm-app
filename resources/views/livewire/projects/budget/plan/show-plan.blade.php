<div>
    @section('title')
        Budget Plan
    @endsection
    <!--BUTTON NAVIGASI-->
    <div class="d-flex justify-content-end">
        <button wire:click='btnPlan_Clicked' class="btn btn-sm btn-success mb-3 mx-2" type="button"
            data-bs-toggle="offcanvas" data-bs-target="#createPlan" aria-controls="createPlan">
            Create Budget Plan
        </button>
        <button wire:click='generatePdf' class="btn btn-sm btn-primary mb-3 mx-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                class="bi bi-file-earmark-pdf-fill" viewBox="0 0 16 16">
                <path
                    d="M5.523 12.424q.21-.124.459-.238a8 8 0 0 1-.45.606c-.28.337-.498.516-.635.572l-.035.012a.3.3 0 0 1-.026-.044c-.056-.11-.054-.216.04-.36.106-.165.319-.354.647-.548m2.455-1.647q-.178.037-.356.078a21 21 0 0 0 .5-1.05 12 12 0 0 0 .51.858q-.326.048-.654.114m2.525.939a4 4 0 0 1-.435-.41q.344.007.612.054c.317.057.466.147.518.209a.1.1 0 0 1 .026.064.44.44 0 0 1-.06.2.3.3 0 0 1-.094.124.1.1 0 0 1-.069.015c-.09-.003-.258-.066-.498-.256M8.278 6.97c-.04.244-.108.524-.2.829a5 5 0 0 1-.089-.346c-.076-.353-.087-.63-.046-.822.038-.177.11-.248.196-.283a.5.5 0 0 1 .145-.04c.013.03.028.092.032.198q.008.183-.038.465z" />
                <path fill-rule="evenodd"
                    d="M4 0h5.293A1 1 0 0 1 10 .293L13.707 4a1 1 0 0 1 .293.707V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2m5.5 1.5v2a1 1 0 0 0 1 1h2zM4.165 13.668c.09.18.23.343.438.419.207.075.412.04.58-.03.318-.13.635-.436.926-.786.333-.401.683-.927 1.021-1.51a11.7 11.7 0 0 1 1.997-.406c.3.383.61.713.91.95.28.22.603.403.934.417a.86.86 0 0 0 .51-.138c.155-.101.27-.247.354-.416.09-.181.145-.37.138-.563a.84.84 0 0 0-.2-.518c-.226-.27-.596-.4-.96-.465a5.8 5.8 0 0 0-1.335-.05 11 11 0 0 1-.98-1.686c.25-.66.437-1.284.52-1.794.036-.218.055-.426.048-.614a1.24 1.24 0 0 0-.127-.538.7.7 0 0 0-.477-.365c-.202-.043-.41 0-.601.077-.377.15-.576.47-.651.823-.073.34-.04.736.046 1.136.088.406.238.848.43 1.295a20 20 0 0 1-1.062 2.227 7.7 7.7 0 0 0-1.482.645c-.37.22-.699.48-.897.787-.21.326-.275.714-.08 1.103" />
            </svg>
            Export
        </button>
    </div>

    {{-- <livewire:projects.budget.plan.form-plan :$projectId /> --}}
    <livewire:projects.budget.plan.form-plan :title="$title" />

    {{-- FILTER --}}
    <div class="card p-1 table-responsive">
        <div class="card-header row row-cols-2 row-cols-md-4 row-cols-md-5 g-2">
            <div class="col">
                <label for="" class="form-label">Kategori</label>
                <select wire:model.live.debounce="filters.category_id" class="form-select form-select-sm">
                    <option value="">Select Category</option>
                    @foreach ($categories ?? [] as $item)
                        <option wire:key="{{ $item->id }}" value="{{ $item->id }}">
                            {{ $item->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col">
                <label for="" class="form-label">Search</label>
                <input type="text" wire:model.live.debounce="search" class="form-control form-control-sm">
            </div>

            <div class="col align-self-end d-flex gap-2">
                <button wire:click="resetFilter" class="btn btn-outline-success btn-outline btn-sm">
                    Reset Filter
                </button>
            </div>
        </div>
    </div>


    <!--TABLE-->
    <div class="card p-1 table-responsive">
        <table id="project-table" class="table table-striped table-hover table-sm" style="width:100%">
            <thead class="text-success fw-medium">
                <tr>
                    <th class="fw-medium text-center">Kategori</th>
                    <th class="fw-medium text-center">Sub Kategori</th>
                    <th class="fw-medium text-center">Deskripsi</th>
                    <th class="fw-medium text-center">Satuan</th>
                    <th class="fw-medium text-center">Kuantitas</th>
                    <th class="fw-medium text-center">Harga Satuan</th>
                    <th class="fw-medium text-center">Anggaran Dana</th>
                    <th class="fw-medium text-center">Action</th>
                </tr>
            </thead>

            <tbody>
                {{-- MERGE --}}
                @php
                    $mergeCategory = null;
                    $mergeSubCat = null;
                @endphp

                @foreach ($plans as $plan)
                    <tr wire:key='{{ $plan->id }}'>

                        {{-- merge column Category --}}
                        @if ($plan->category_id != $mergeCategory)
                            {{-- if category now different with past category --}}
                            <td class="text-left"
                                rowspan="{{ $plans->where('category_id', $plan->category_id)->count() }}">
                                {{ $plan->category_name }}
                            </td>
                            @php
                                $mergeCategory = $plan->category_id; //store category for compare next store
                            @endphp
                        @endif

                        {{-- merge column SubCategory --}}
                        @if ($plan->sub_category_id != $mergeSubCat)
                            {{-- if category now different with past category --}}
                            <td class="text-left"
                                rowspan="{{ $plans->where('sub_category_id', $plan->sub_category_id)->count() }}">
                                {{ $plan->sub_category_name }}
                            </td>
                            @php
                                $mergeSubCat = $plan->sub_category_id; //store category for compare next store
                            @endphp
                        @endif

                        <td class="text-left">{{ $plan->name }}</td>
                        <td class="text-left">{{ $plan->uom }}</td>
                        <td class="text-center">{{ $plan->quantity }}</td>
                        <td class="text-center">{{ number_format($plan->unit_price) }}</td>
                        <td class="text-center">{{ number_format($plan->total_per_item) }}</td>


                        <td>
                            {{-- dispatch akan ambil method edit based on table plan yang diambil id plannya --}}
                            {{-- wire:click="$dispatch('method', {id: {{$table->id }}})" --}}
                            <button wire:click="$dispatch('edit', {id: {{ $plan->id }}})"
                                class="btn btn-sm text-warning col">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                    <path
                                        d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325" />
                                </svg>
                            </button>
                        </td>
                        <td>
                            <button wire:confirm="Are you sure want to delete this post?"
                                wire:click='delete({{ $plan->id }})' class="btn btn-sm text-danger col">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                    <path
                                        d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z" />
                                    <path
                                        d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z" />
                                </svg>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot class="fw-medium text-center">
                <tr>
                    <th colspan="6">Total Budget Project</th>
                    <td class="text-right text-bold">{{ number_format($total_all) }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>



<!--SCRIPT-->
@push('scripts')
    <script>
        window.addEventListener('show-create-offcanvas', event => {
            const offcanvas = new bootstrap.Offcanvas('#planForm');
            offcanvas.show();
        });

        window.addEventListener('show-edit-offcanvas', event => {
            const offcanvas = new bootstrap.Offcanvas('#planForm');
            offcanvas.show();
        });

        window.addEventListener('alert', event => {
            alert(event.detail.message);
        });
    </script>
    <script>
        window.addEventListener('alert', event => {
            const {
                type,
                message
            } = event.detail;
            if (type === 'success') {
                alert('Sukses');
            } else if (type === 'error') {
                alert('gagal');
            }
        });
    </script>
@endpush





















{{-- window.addEventListener('show-offcanvas', event => {
    //     const offcanvas = new bootstrap.Offcanvas(document.getElemenById('createPlanForm'));
    //     offcanvas.show();
    // }); --}}

{{-- // kode awal
    // window.addEventListener('show-create-offcanvas', event => {
    //         const offcanvas = new bootstrap.Offcanvas('#planForm');
    //         offcanvas.show();
    //     });

    // window.addEventListener('show-edit-offcanvas', event => {
    //     const offcanvas = new bootstrap.Offcanvas('#planForm');
    //     offcanvas.show();
    // }); --}}
