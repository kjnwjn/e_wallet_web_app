<div class="col-lg-9 col-md-10 col-xs-6 main__content">
    <div class="row p-3">
        <div class="col my-4 p-3 bg-white border shadow-sm lh-sm">
            <div class="table-list-title">
                <h2 class="ps-4 position-relative">List Account</h2>
                <div class="dropdown ">
                    <button class="btn btn-secondary dropdown-toggle list__type-account" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Type of Account
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="#" onclick="renderPendingData()">Pending</a>
                        <a class="dropdown-item" href="#" onclick="renderActivedData()">Actived</a>
                        <a class="dropdown-item" href="#" onclick="renderDisabledData()">Disabled</a>
                        <a class="dropdown-item" href="#" onclick="renderAllAccountData()">All Account</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive ">
            <table class="table table-bordered table-striped mt-0">
                <thead>
                    <tr>
                        <th>email</th>
                        <th>Phone Number</th>
                        <th>Status</th>
                        <th>Fullname</th>
                        <th>gender</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="tbody__details">

                </tbody>
            </table>
        </div>
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

        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item"><a class="page-link" href="#">Next</a></li>
            </ul>
        </nav>
    </div>
</div>
<!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script> -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script>
    const urlAllAccount = 'http://localhost/api/admin/list-account'
    const urlPendingAccount = 'http://localhost/api/admin/list-account/pending'
    const urlActivedAccount = 'http://localhost/api/admin/list-account/actived'
    const urlDisabledAccount = 'http://localhost/api/admin/list-account/disabled'
    
    function renderData(url = ''){
        fetch(url)
            .then(response => response.json())
            .then(response => {
                // console.log(AllAccount);
                if(response.status == true){
                    $('#tbody__details').html(response.data.map((element) => {
                        if(element.role == 'pending'){
                            return `
                            <tr>
                                <td>${element.email}</td>
                                <td class="align-middle">
                                    ${element.phoneNumber}
                                </td>
                                <td class="align-middle"><span class="badge badge-warning">Pending</span></td>
                                <td class="align-middle">${element.fullname}</td>
                                <td>${element.gender}</td>
                                <td class="align-middle text-center">
                                    <button class="btn btn-theme btn_show" data-toggle="modal" data-target="#orderInfo">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                    <button class="btn btn-success" data-toggle="modal" data-target="#orderUpdate"><i class="fa fa-pencil"></i></button>
                                    <button class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                            `
                        }else if(element.role == 'actived'){
                            return `
                            <tr>
                                <td>${element.email}</td>
                                <td class="align-middle">
                                    ${element.phoneNumber}
                                </td>
                                <td class="align-middle"><span class="badge badge-success">Actived</span></td>
                                <td class="align-middle">${element.fullname}</td>
                                <td>${element.gender}</td>
                                <td class="align-middle text-center">
                                    <button class="btn btn-theme btn_show" data-toggle="modal" data-target="#orderInfo">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                    <button class="btn btn-success" data-toggle="modal" data-target="#orderUpdate"><i class="fa fa-pencil"></i></button>
                                    <button class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                            `
                        }else{
                            return `
                            <tr>
                                <td>${element.email}</td>
                                <td class="align-middle">
                                    ${element.phoneNumber}
                                </td>
                                <td class="align-middle"><span class="badge badge-success">Disable</span></td>
                                <td class="align-middle">${element.fullname}</td>
                                <td>${element.gender}</td>
                                <td class="align-middle text-center">
                                    <button class="btn btn-theme btn_show" data-toggle="modal" data-target="#orderInfo">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                    <button class="btn btn-success" data-toggle="modal" data-target="#orderUpdate"><i class="fa fa-pencil"></i></button>
                                    <button class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                            `
                        }
                    }))
                }else{
                    $('#tbody__details').html(response.msg)
                }
            })
       
    }
    renderData(urlAllAccount);
    function renderPendingData(){
        renderData(urlPendingAccount)
    }
    function renderActivedData(){
        renderData(urlActivedAccount)
    }
    function renderDisabledData(){
        renderData(urlDisabledAccount)
    }
    function renderAllAccountData(){
        renderData(urlAllAccount)
    }
  
</script>