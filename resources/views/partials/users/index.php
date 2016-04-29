<div class="box" ng-controller="UserController" ng-init="getUser()">
    <div class="box-header bg-transparent">
        <h3 class="box-title">
            <i class="icon-menu"></i>
            <span>Users</span>
        </h3>
        <div class="pull-right box-tools">
            <span class="box-btn" data-widget="collapse">
            <i class="icon-minus"></i>
        </span>
        </div>
    </div>
    <div class="box-body">                    
        <div class="row" ng-show="has_role">
            <div class="col-md-4 col-md-offset-8">
                <div class="pull-right">
                    <a href="/users/create" class="btn btn-success">
                        <i class="fa fa-plus"></i> Tambah Data
                    </a>
                </div>
            </div>
        </div>        
        <div class="table-responsive dataTables_wrapper" >
            <table class="table" datatable="ng">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>User Name</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>                    
                    <tr ng-repeat="user in user_list">
                        <td align="center">[[ $index+1 ]]</td>
                        <td>[[ user.username ]]</td>
                        <td>[[ user.email ]]</td>
                        <td>[[ user.phone_number ]]</td>
                        <td>
                            <a ng-href="/users/profile/[[user.id]]" class="btn btn-default" title="User Profile">
                                <i class="glyphicon glyphicon-user"></i>
                            </a>
                            
                            
                            <button ng-show="user.status === true" class="btn btn-success" id="btn-approval" ng-click="setActive(user.id)" >
                                <i class="glyphicon glyphicon-floppy-saved"></i>
                            </button>
                        
                            
                            <a ng-show="user.roles.length > '0'" href="#" class="btn btn-default" title="assign role">
                                <i class="glyphicon glyphicon-share"></i>
                            </a>                            
                            <button ng-if="['root', 'admin'].indexOf(user.has_role) === -1 || user.roles.length <= '0'" class="btn btn-danger" id="btn-delete" type="button" user.destroy ng-click="deleteUser(user.id)">
                                <i class="glyphicon glyphicon-trash"></i>
                            </button>
                            
                        </td>
                    </tr>                    
                </tbody>
            </table>
        </div>
    </div>    
</div>