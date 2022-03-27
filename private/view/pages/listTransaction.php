<div class="col-lg-9 col-md-10 col-xs-6 main__content">
    <div class="row p-3">
        <div class="col my-4 p-3 bg-white border shadow-sm lh-sm">
            <div class="table-list-title">
                <h2 class="ps-4 mb-4">List Transactions</h2>
                <div class="dropdown ">
                    <button class="btn btn-secondary dropdown-toggle list__type-account" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Type of Transactions
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="#">Withdraw</a>
                        <a class="dropdown-item" href="#">Transfer</a>
                        <a class="dropdown-item" href="#">All Transactions</a>
                    </div>
                </div>
            </div>
        </div>
        
        <table class="table table-bordered table-striped mt-0" >
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Status</th>
                    <th>Total</th>
                    <th>Order date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Ord#13</td>
                    <td class="align-middle">
                        Stephanie Cott
                    </td>
                    <td class="align-middle"><span class="badge badge-warning">Pending</span></td>
                    <td class="align-middle">$200</td>
                    <td>15/09/2018</td>
                    <td class="align-middle text-center">
                        <button class="btn btn-theme btn_show" data-toggle="modal" data-target="#orderInfo">
                            <i class="fa fa-eye"></i>
                        </button>
                        <button class="btn btn-success" data-toggle="modal" data-target="#orderUpdate"><i
                                class="fa fa-pencil"></i></button>
                        <button class="btn btn-danger"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
                <tr>

                    <td>Ord#14</td>
                    <td class="align-middle">
                        Andy Webb
                    </td>
                    <td class="align-middle"><span class="badge badge-danger">Cancelled</span></td>
                    <td class="align-middle">$200</td>
                    <td>15/09/2018</td>
                    <td class="align-middle text-center">
                        <button class="btn btn-theme" data-toggle="modal" data-target="#orderInfo">
                            <i class="fa fa-eye"></i>
                        </button>
                        <button class="btn btn-success" data-toggle="modal" data-target="#orderUpdate"><i
                                class="fa fa-pencil"></i></button>
                        <button class="btn btn-danger"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
                <tr>

                    <td>Ord#15</td>
                    <td class="align-middle">
                        Andy Webb
                    </td>
                    <td class="align-middle"><span class="badge badge-success">Delivered</span></td>
                    <td class="align-middle">$200</td>
                    <td>15/09/2018</td>
                    <td class="align-middle text-center">
                        <button class="btn btn-theme" data-toggle="modal" data-target="#orderInfo">
                            <i class="fa fa-eye"></i>
                        </button>
                        <button class="btn btn-success" data-toggle="modal" data-target="#orderUpdate"><i
                                class="fa fa-pencil"></i></button>
                        <button class="btn btn-danger"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
                <tr>

                    <td>Ord#16</td>
                    <td class="align-middle">
                        Stephanie Cott
                    </td>
                    <td class="align-middle"><span class="badge badge-warning">Pending</span></td>
                    <td class="align-middle">$200</td>
                    <td>15/09/2018</td>
                    <td class="align-middle text-center">
                        <button class="btn btn-theme" data-toggle="modal" data-target="#orderInfo">
                            <i class="fa fa-eye"></i>
                        </button>
                        <button class="btn btn-success" data-toggle="modal" data-target="#orderUpdate"><i
                                class="fa fa-pencil"></i></button>
                        <button class="btn btn-danger"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
                <tr>

                    <td>Ord#17</td>
                    <td class="align-middle">
                        Andy Webb
                    </td>
                    <td class="align-middle"><span class="badge badge-danger">Cancelled</span></td>
                    <td class="align-middle">$200</td>
                    <td>15/09/2018</td>
                    <td class="align-middle text-center">
                        <button class="btn btn-theme" data-toggle="modal" data-target="#orderInfo">
                            <i class="fa fa-eye"></i>
                        </button>
                        <button class="btn btn-success" data-toggle="modal" data-target="#orderUpdate"><i
                                class="fa fa-pencil"></i></button>
                        <button class="btn btn-danger"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
                <tr>

                    <td>Ord#18</td>
                    <td class="align-middle">
                        Andy Webb
                    </td>
                    <td class="align-middle"><span class="badge badge-success">Delivered</span></td>
                    <td class="align-middle">$200</td>
                    <td>15/09/2018</td>
                    <td class="align-middle text-center">
                        <button class="btn btn-theme" data-toggle="modal" data-target="#orderInfo">
                            <i class="fa fa-eye"></i>
                        </button>
                        <button class="btn btn-success" data-toggle="modal" data-target="#orderUpdate"><i
                                class="fa fa-pencil"></i></button>
                        <button class="btn btn-danger"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
                <tr>
                    <td>Ord#19</td>
                    <td class="align-middle">
                        Stephanie Cott
                    </td>
                    <td class="align-middle"><span class="badge badge-warning">Pending</span></td>
                    <td class="align-middle">$200</td>
                    <td>15/09/2018</td>
                    <td class="align-middle text-center">
                        <button class="btn btn-theme" data-toggle="modal" data-target="#orderInfo">
                            <i class="fa fa-eye"></i>
                        </button>
                        <button class="btn btn-success" data-toggle="modal" data-target="#orderUpdate"><i
                                class="fa fa-pencil"></i></button>
                        <button class="btn btn-danger"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
        </table>

        <!-- INfor modal -->
        <div class="modal fade" id="orderInfo" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Ord#13 details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th scope="row">Item</th>
                                    <th>Quantity</th>
                                    <th>Unit price</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td scope="row">Red Shoes</td>
                                    <td>2</td>
                                    <td>$400</td>
                                    <td>$800</td>
                                </tr>
                                <tr>
                                    <td scope="row">Blue shirt</td>
                                    <td>1</td>
                                    <td>$400</td>
                                    <td>$400</td>
                                </tr>
                                <tr>
                                    <td scope="row">Knickers</td>
                                    <td>3</td>
                                    <td>$300</td>
                                    <td>$900</td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="text-right mt-4 p-4">
                            <p><strong>Sub - Total amount: $14,768.00</strong></p>
                            <p><strong>Shipping: $1000.00</strong></p>
                            <p><span>vat(10%): $150.00</span></p>
                            <h4 class="mt-2"><strong>Total: $16,050.00</strong></h4>
                        </div>
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-right">
            <button class="btn btn-outline-theme"><i class="fa fa-eye"></i> View full Transactions</button>
        </div>
    </div>
</div>