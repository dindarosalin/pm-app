<div>
    <div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="offCanvasFormSubCriteria"
        aria-labelledby="offCanvasFormCriteriaLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offCanvasFormCriteriaLabel">Form Task Sub Criterias</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form wire:submit='save'>
                <div class="mb-3">
                    <label class="form-label"><span class="text-danger">*</span>Select Criteria:</label>
                    <select wire:model="cId" class="form-select form-control-sm mb-3" aria-label="Select Column Name"
                        required>
                        <option value="" selected>Pilih kolom</option>
                        @foreach ($cNameList as $a)
                            <option value="{{ $a->id }}">{{$a->c_name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label"><span class="text-danger">*</span>Subcriteria Label:</label>
                    <input wire:model='scLabel' class="form-control form-control-sm" type="text"
                        placeholder="Criteria Value" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Minimum:</label>
                    <input wire:model='scMin' class="form-control form-control-sm" type="number"
                        placeholder="Minimum">
                </div>

                <div class="mb-3">
                    <label class="form-label">Maximum:</label>
                    <input wire:model='scMax' class="form-control form-control-sm" type="number"
                        placeholder="Maximum">
                </div>

                <div class="mb-3">
                    <label class="form-label"><span class="text-danger">*</span>Value:</label>
                    <input wire:model='scValue' class="form-control form-control-sm" type="number"
                        placeholder="Criteria Value" step="0.25" required>
                </div>

                <div class="form-floating mb-3">
                    <textarea class="form-control" wire:model='scDesc' placeholder="Description" id="floatingTextarea"></textarea>
                    <label for="floatingTextarea">Description</label>
                </div>
                <button type="submit" class="btn btn-sm btn-primary">Save</button>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center my-2">
                <p>List of Task Subcriteria</p>
                <button class="btn btn-sm btn-outline-primary" wire:click="$dispatch('show-offcanvas-subcriteria')">
                    <span class="fa fa-plus"></span>
                    Create new Subcriteria
                </button>
            </div>
        </div>
        <div class="table-responsive card-body">
            <table class="table table-sm table-striped">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Criteria Name</th>
                        <th>Sub Criteria Label</th>
                        <th>Minimum</th>
                        <th>Maximum</th>
                        <th>Value</th>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($scNameList as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->criteria_name }}</td>
                            <td>{{ $item->sc_label }}</td>
                            <td>{{ $item->sc_min }}</td>
                            <td>{{ $item->sc_max }}</td>
                            <td>{{ $item->sc_value }}</td>
                            <td>{{ $item->sc_description }}</td>
                            <td>
                                <div class="d-flex gap-2 align-items-center">

                                    <!-- Edit icon -->
                                    <p role="button" wire:click='edit({{ $item->id }})'class="text-warning m-0 p-0"
                                        style="cursor: pointer;">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </p>

                                    <!-- Delete icon -->
                                    <p role="button" wire:click="alertConfirm({{ $item->id }})"
                                        class="text-danger m-0 p-0" style="cursor: pointer;">
                                        <i class="fa-solid fa-trash"></i>
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        window.addEventListener('show-offcanvas-subcriteria', event => {
            const offcanvas = new bootstrap.Offcanvas('#offCanvasFormSubCriteria');
            offcanvas.show();
        });
    </script>
@endpush
