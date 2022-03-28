<div class="col-lg-9 col-md-10 col-xs-6 main__content">
    <div class="row p-3">
        <div class="col my-4 p-3 bg-white border shadow-sm lh-sm">
            <div class="table-list-title">
                <h2 class="ps-4">List Transaction</h2>
                <div class="dropdown ">
                    <button class="btn btn-secondary dropdown-toggle list__type-account" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Type of Transaction
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="#" onclick="renderWithDrawData()">With draw</a>
                        <a class="dropdown-item" href="#" onclick="renderTransferData()">Transfer</a>
                        <a class="dropdown-item" href="#" onclick="renderAllTransactionsData()">All Transaction</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive ">
            <table id="table__details" class="table table-bordered table-striped mt-0">
                <thead id="thead__details">
                        
                </thead>   
                <tbody id="tbody__details">
                </tbody>
            </table>
        </div>
        <!-- Modal transaction-->
        <div class="modal fade" id="modal__details" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Transaction details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div  class="modal-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead id="transaction-thead" class="thead-dark ">
                                
                            </thead>
                            <tbody id="transaction-tbody">    
                            </tbody>
                        </table>
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
    const urlAllTransaction = 'http://localhost/api/admin/list-transaction-confirm'
    const urlWithDrawTransaction = 'http://localhost/api/admin/list-transaction-confirm/withdraw'
    const urlTransferTransaction = 'http://localhost/api/admin/list-transaction-confirm/transfer'
    const urlDetailTransaction = 'http://localhost/api/admin/transaction-detail/'
    const urlAcceptTransaction = 'http://localhost/api/admin/accept-transaction/'
    const urlCancelTransaction = 'http://localhost/api/admin/cancel-transaction/'
    

    // show list item
    function renderData(url = urlAllTransaction){
        fetch(url)
            .then(response => response.json())
            .then(response => {
                if(response.status == true){
                    thead = `<tr>
                                <th>Transaction id</th>
                                <th>email</th>
                                <th>type_transaction</th>
                                <th>value money</th>
                                <th>Action</th>
                            </tr>`
                    $('#thead__details').html(thead)
                    $('#tbody__details').html(response.data.map((element) => {
                        if(element.type_transaction == '2'){
                            return `
                                    <tr>
                                        <td>${element.transaction_id}</td>
                                        <td class="align-middle">
                                            ${element.email}
                                        </td>
                                        <td class="align-middle"><span class="badge badge-warning">transfer transaction</span></td>
                                        <td>${element.value_money}</td>
                                        <td class="align-middle text-center">
                                            <button class="btn btn-theme btn_show" data-toggle="modal" data-target="#modal__details"
                                             onclick="transaction_detail(` +element.transaction_id +`)">
                                            <i class="fa fa-eye"></i>
                                            </button>
                                            <button class="btn btn-success" onclick ="confirmTransaction(`+ element.transaction_id +`)" ><i class="fa-solid fa-check"></i></button>
                                            <button class="btn btn-danger" onclick ="cancelTransaction(`+ element.transaction_id +`)"><i class="fas fa-trash"></i></button>
                                        </td>
                                    </tr>
                                `
                        }else{
                            return `
                                    <tr>
                                        <td>${element.transaction_id}</td>
                                        <td class="align-middle">
                                            ${element.email}
                                        </td>
                                        <td class="align-middle"><span class="badge badge-success">withdraw transaction</span></td>
                                        <td>${element.value_money}</td>
                                        <td class="align-middle text-center">
                                            <button class="btn btn-theme btn_show" data-toggle="modal" data-target="#modal__details">
                                            <i class="fa fa-eye"></i>
                                            </button>
                                            <button class="btn btn-success" onclick ="confirmTransaction(`+ element.transaction_id +`)"><i class="fa-solid fa-check"></i></button>
                                            <button class="btn btn-danger" onclick ="cancelTransaction(`+ element.transaction_id +`)"><i class="fas fa-trash"></i></button>
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
    
    renderData();
    function renderWithDrawData(){
        renderData(urlWithDrawTransaction)
    }
    function renderTransferData(){
        renderData(urlTransferTransaction)
    }
    function renderAllTransactionsData(){
        renderData(urlAllTransaction)
    }



    // show modal
    $('#modal__details').on('show.bs.modal', function (e) {
        var button = $(event.relatedTarget)
        var modal = $(this)
        
    })

    function transaction_detail(transaction_id){
        fetch(urlDetailTransaction+transaction_id)
            .then(response => response.json())
            .then(response => {
                if(response.status){
                    console.log(typeof (response.data.type_transaction))
                    if(response.data.type_transaction == "2"){
                        console.log(123)
                        $('#transaction-thead').html(`
                            <tr>
                            <th scope="col">transaction id</th>
                            <th scope="col">transaction type</th>
                            <th scope="col">email sender</th>
                            <th scope="col">phone Recipient</th>
                            <th scope="col">money</th>
                            <th scope="col">note</th>
                            </tr>
                        `
                        )
                        $('#transaction-tbody').html(`
                            <tr>
                                <th scope="row">${response.data.transaction_id}</th>
                                <td>transfer transaction</td>
                                <td>${response.data.email}</td>
                                <td>${response.data.phoneRecipient}</td>
                                <td>${response.data.value_money}</td>
                                <td>${response.data.description}</td>
                            </tr>
                        `
                        )
                    }else{
                        console.log(345)
                        $('#transaction-thead').html(`
                            <tr>
                            <th scope="col">transaction id</th>
                            <th scope="col">email</th>
                            <th scope="col">transaction type</th>
                            <th scope="col">card id</th>
                            <th scope="col">money</th>
                            <th scope="col">description</th>
                            </tr>
                        `
                        )
                        $('#transaction-tbody').html(`
                            <tr>
                                <th>${response.data.transaction_id}</th>
                                <td>${response.data.email}</td>
                                <td>withdraw transaction</td>
                                <td>111111</td>
                                <td>${response.data.value_money}</td>
                                <td>${response.data.description}</td>
                            </tr>
                        `
                        )
                    }
                }
            })
    }

    // handle comfirm and cancel request for transactions
    function confirmTransaction(transaction_id){
        console.log(transaction_id)
        alertify.confirm("Are you sure that you wan to update this transaction ?",
        function(){
                fetch(urlAcceptTransaction + transaction_id)
                .then(response => response.json())
                .then(data => {
                    console.log(data)
                    if(data.status){
                        alertify.success(data.msg);
                        setTimeout(location.reload(), 5000);
                    }else{
                        alertify.error(data.msg);
                    }
                })
        },
        function(){
            alertify.error('Cancel');
        });
    }

    function cancelTransaction(transaction_id){
        
        alertify.confirm("Are you sure that you wan to update this transaction ?",
        function(){
            fetch(urlAcceptTransaction + transaction_id)
                .then(response => response.json())
                .then(data => {
                    console.log(data)
                    if(data.status){
                        alertify.success(data.msg);
                        setTimeout(location.reload(), 5000);
                    }else{
                        alertify.error(data.msg);
                    }
                })
        },
        function(){
            alertify.error('Cancel');
        });
    }
  
</script>