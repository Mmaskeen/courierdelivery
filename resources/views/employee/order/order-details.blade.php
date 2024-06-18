@extends('layouts.master')
@section('page-title')
    <title>Employee | All Orders</title>
@endsection
@section('body')
    <div class="content-area">
        <div class="container-fluid">
            <div class="page-header">
                <h4 class="page-title">Orders</h4>
            </div>
            <div class="row row-cards">
                <div class="col-12">
                    <div class="card">
                        <div class="table-responsive" >
                            <table class="table card-table table-vcenter text-nowrap" id="table_id">
                                <thead>
                                <tr>
                                    <th>
                                                            <span class="at-checkbox">
                                                                <input class="checkall" type="checkbox" name="selectall" id="checkall2">
                                                                <span id="totalSelected"> (0)</span>
                                                                <label for="checkall2"></label>
                                                            </span>
                                    </th>
                                    <th class="w-1">Order ID <i class="ion-arrow-down-b sorting-orders" data-type="desc" data-column="id"></i><i class="ion-arrow-up-b sorting-orders" data-type="asc" data-column="id"></i></th>
                                    <th>Name <i class="ion-arrow-down-b sorting-orders" data-type="desc" data-column="name"></i><i class="ion-arrow-up-b sorting-orders" data-type="asc" data-column="name"></i></th>
                                    <th>Product URL <i class="ion-arrow-down-b sorting-orders" data-type="desc" data-column="product"></i><i class="ion-arrow-up-b sorting-orders" data-type="asc" data-column="product"></i></th>
                                    <th>Address <i class="ion-arrow-down-b sorting-orders" data-type="desc" data-column="address"></i><i class="ion-arrow-up-b sorting-orders" data-type="asc" data-column="address"></i></th>
                                    <th>City <i class="ion-arrow-down-b sorting-orders" data-type="desc" data-column="city"></i><i class="ion-arrow-up-b sorting-orders" data-type="asc" data-column="city"></i></th>
                                    <th>Cell Number</th>
                                    <th>QTY <i class="ion-arrow-down-b sorting-orders" data-type="desc" data-column="quantity"></i><i class="ion-arrow-up-b sorting-orders" data-type="asc" data-column="quantity"></i></th>
                                    <th>Price <i class="ion-arrow-down-b sorting-orders" data-type="desc" data-column="price"></i><i class="ion-arrow-up-b sorting-orders" data-type="asc" data-column="price"></i></th>
                                    <th>Status <i class="ion-arrow-down-b sorting-orders" data-type="desc" data-column="status"></i><i class="ion-arrow-up-b sorting-orders" data-type="asc" data-column="status"></i></th>
                                    <th>Date <i class="ion-arrow-down-b sorting-orders" data-type="desc" data-column="created_at"></i><i class="ion-arrow-up-b sorting-orders" data-type="asc" data-column="created_at"></i></th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody id="mainTableBody">
                                @include('admin.order.order-table')
                                </tbody>
                            </table>

                            {{ $orders->links() }}



                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade at-viewstatusmodal at-modal" id="at-viewstatusmodal" tabindex="-1" role="dialog" aria-labelledby="at-viewstatusmodal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Status Detail</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="at-viewstatusholder">
                        <div class="at-viewstatushead">
                            <span>Name</span>
                            <span>Status</span>
                            <span>Time</span>
                        </div>
                        <ul class="at-viewstatuscontent">
                            <li>
                                <h2>Waleed</h2>
                            </li>
                            <li>
                                <em class="at-statuspreview badge-Dispatched">Dispatched</em>
                            </li>
                            <li>
                                <h2>12: 30</h2>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
