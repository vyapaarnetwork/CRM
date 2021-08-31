<div class="page-container">
    <?php echo $adminMenu; ?>
    <div class="main-content-inner">
        <div class="row">
            <div class="col-lg-12 mt-3">
                <span id="errorReturn"></span>
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Sales Associate</h4>
                        <select name="status" id="vendorBulk" class="custome-select border-1 pr-3 pl-2 pt-2 pb-2 m-2">
                            <option value="">Select</option>
                            <option value="pending">Pending</option>
                            <option value="active">Active</option>
                            <option value="delete">Delete</option>
                        </select>
                        <div class="single-table">
                            <div class="table-responsive">
                                <table id="salesTableList" class="table text-center">
                                    <thead class="text-uppercase bg-primary">
                                        <tr class="text-white">
                                            <th scope="col">
                                                <div class="custom-control custom-checkbox text-center">
                                                    <input type="checkbox" class="custom-control-input" id="all" name="sales[]">
                                                    <label class="custom-control-label" for="all" style="top: -15px;"></label>
                                                </div>
                                            </th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Mobile Number</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Company Name</th>
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