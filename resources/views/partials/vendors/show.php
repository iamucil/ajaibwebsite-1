<div class="box bg-white" ng-controller="VendorController" ng-init="getShow()">
    <div class="box-header bg-transparent">
        <h3 class="box-title"><i class="icon-menu"></i><span>Vendor - Detail</span></h3>
        <div class="pull-right box-tools">
            <span class="box-btn" data-widget="collapse"><i class="icon-minus"></i></span>
        </div>            
    </div>
    <div class="box-body pad-forty">
        <h3>[[vendor.name]] <small>[[vendor.category_name]]</small></h3>
        <p>[[vendor.description]]</p>
        <hr />
        <a class="btn btn-default" type="button" ng-href="/vendors">Kembali</a>

    </div>
</div>
