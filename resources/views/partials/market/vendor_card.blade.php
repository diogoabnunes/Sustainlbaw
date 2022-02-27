<?php
$dcp = $vendor->location->dcp;
$district = $dcp->district;
$county = $dcp->county;
?>

<div id="{{ 'vendor_' . $vendor->vendor_id }}" class="eventcollumns col-lg-3 col-md-6 col-sm-6 col-xs-12">
    <a href="{{ '/market/' . $vendor->vendor_id }}" class="text-decoration-none text-dark">
        <img class="img-fluid" src="{{ url('storage/images/' . $vendor->image_path) }}"
            alt="{{ $vendor->image_path }}" />

        <section class="recent-text-post border rounded-bottom p-3">
            <h5 class="m-1 text-center">{{ $vendor->name }}</h5>
            <p class="m-1 text-center">{{ $vendor->job }}</p>
            <p class="font-weight-bold text-center">{{ $district . ', ' . $county }}</p>
        </section>
    </a>

    @if (Auth::check() && Auth::user()->isEditor())
        <div class="post-settings">
            <a href="{{ '/market/' . $vendor->vendor_id . '/edit' }}" class="btn btn-dark rounded-circle"><i
                    class="fas fa-pencil-alt"></i></a>
            <button class="btn btn-danger rounded-circle" data-toggle="modal"
                data-target="{{ '#modalDeleteVendor' . $vendor->vendor_id }}"><i class="fas fa-times"></i></a>
        </div>
    @endif

</div>

<div class="modal fade" id="{{ 'modalDeleteVendor' . $vendor->vendor_id }}" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h4 class="modal-title w-100 font-weight-bold">Tens a certeza que queres eliminar este produtor?</h4>
                <input type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
            </div>
            <div class="modal-footer d-flex justify-content-end">
                <input type="submit" data-dismiss="modal" id="{{ 'delete-button' . $vendor->vendor_id }}"
                    class="btn btn-light" name="submit" value="Cancelar" />
                <input type="submit" onclick="deleteVendor({{ $vendor->vendor_id }})" class="btn btn-danger"
                    name="submit" value="Eliminar" />
            </div>
        </div>
    </div>
</div>
