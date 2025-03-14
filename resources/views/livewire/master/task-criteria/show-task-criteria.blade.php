@section('title', 'Task Criterias')
<div>
    <div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="offCanvasFormCriteria"
        aria-labelledby="offCanvasFormCriteriaLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offCanvasFormCriteriaLabel">Form Task Criterias</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form wire:submit='save'>
                <div class="mb-3">
                    <label class="form-label"><span class="text-danger">*</span>Name: </label>
                    <input wire:model='cName' class="form-control form-control-sm" type="text"
                        placeholder="Criteria Name" required>
                </div>
                <div class="mb-3">
                    <label class="form-label"><span class="text-danger">*</span>Value:</label>
                    <input wire:model='cValue' class="form-control form-control-sm" type="number"
                        placeholder="Criteria Value" required>
                </div>
                <div class="d-flex gap-2 mb-3">
                    <div class="form-check">
                        <input class="form-check-input" wire:model='cAttribute' type="radio" name="cAttribute"
                            id="costCriteria" value="cost">
                        <label class="form-check-label" for="costCriteria">
                            Cost Criteria
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" wire:model='cAttribute' type="radio" name="cAttribute"
                            id="benefitCriteria" value="benefit">
                        <label class="form-check-label" for="benefitCriteria">
                            Benefit Criteria
                        </label>
                    </div>
                </div>
                <div class="form-floating mb-3">
                    <textarea class="form-control" wire:model='cDescription' placeholder="Leave a comment here" id="floatingTextarea"></textarea>
                    <label for="floatingTextarea">Description</label>
                </div>
                <button type="submit" class="btn btn-sm btn-primary">Save</button>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center my-2">
                <p>List of Task Criteria</p>
                <button class="btn btn-sm btn-outline-primary" wire:click="$dispatch('show-offcanvas-criteria')">
                    <span class="fa fa-plus"></span>
                    Create new Criteria
                </button>
            </div>
        </div>
        <div class="table-responsive card-body">
            <table class="table table-sm table-striped">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Criteria Name</th>
                        <th>Criteria Atrribute</th>
                        <th>Criteria Value</th>
                        <th>Criteria Description</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($taskCriterias as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->c_name }}</td>
                            <td>{{ $item->c_attribute }}</td>
                            <td>{{ $item->c_value }}</td>
                            <td>{{ $item->c_description }}</td>
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
        window.addEventListener('show-offcanvas-criteria', event => {
            const offcanvas = new bootstrap.Offcanvas('#offCanvasFormCriteria');
            offcanvas.show();
        });
    </script>
@endpush
