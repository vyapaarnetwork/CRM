<div class="page-container">
    <?php echo $adminMenu; ?>
    <div class="main-content-inner">
        <div class="row">
            <div class="col-lg-12 mt-3">
                <span id="errorReturn"></span>
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title mb-2">Product</h4>
                        <select name="status" id="productBulk" class="custome-select border-1 pr-3 pl-2 pt-2 pb-2 m-2">
                            <option value="">Select</option>
                            <option value="pending">Pending</option>
                            <option value="active">Active</option>
                            <option value="delete">Delete</option>
                        </select>
                        <div class="single-table">
                            <div class="table-responsive">
                                <table id="productTableList" class="table text-center">
                                    <thead class="text-uppercase bg-primary">
                                        <tr class="text-white">
                                            <th scope="col">
                                                <div class="custom-control custom-checkbox text-center">
                                                    <input type="checkbox" class="custom-control-input" id="all" name="product[]">
                                                    <label class="custom-control-label" for="all" style="top: -15px;"></label>
                                                </div>
                                            </th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Vendor Name</th>
                                            <th scope="col">Price</th>
                                            <th scope="col">Sell Price</th>
                                            <th scope="col">Date</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- table primary end -->
        </div>
    </div>
</div>