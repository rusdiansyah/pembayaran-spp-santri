<div class="m-2 d-flex justify-content-between">
    <div class="col-1">
        <select wire:model.live="paginate" class="form-control">
            <option value="10">10</option>
            <option value="25">25</option>
            <option value="50">50</option>
            <option value="100">100</option>
        </select>
    </div>
    <div class="col-4">
        <input wire:model.live.debounce.300ms="search" type="text" placeholder="Pencarian ..." class="form-control">
    </div>
</div>
