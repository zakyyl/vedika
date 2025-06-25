<!-- partials/rawatjalan/action_buttons.blade.php -->
<div class="card">
    <div class="card-footer">
        <div class="row">
            <div class="col-6">
                <a href="{{ route('rawatjalan.index') }}" class="btn btn-default">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
            <div class="col-6 text-right">
                <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#updateModal">
                    <i class="fas fa-edit"></i> Update Status
                </button>
            </div>
        </div>
    </div>
</div>
