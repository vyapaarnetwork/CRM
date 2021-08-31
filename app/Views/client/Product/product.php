<div class="container">
    <div class="row">
        <div class="col-lg-12 mt-3">
            <div class="card">
                <div class="card-body">
                    <span id="errorReturn"></span>
                    <h1 class="header-title mb-5 d-flex justify-content-between align-items-center">
                        <span>Your Products</span>
                        <button type="button" id="productAdd" class="btn btn-primary mb-3">
                            Add
                        </button>
                    </h1>
                    <div class="single-table">
                        <div class="table-responsive">
                            <table id="productTableList" class="table text-center">
                                <thead class="text-uppercase bg-primary">
                                    <tr class="text-white">
                                        <th scope="col">Name</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Sell Price</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Date</th>
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
    </div>
</div>
<div id="Product">
    <div class="modal-body">
        <p id="productDetailError"></p>
        <form method="POST" id="productDetails" novalidate>
            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <label for="productName">Name</label>
                    <input type="text" name="productName" class="form-control" id="productName" placeholder="Product Name">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="productImage">Image</label>
                    <input type="file" name="productImage" class="form-control" id="productImage">
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-4 mb-3">
                    <label for="productPrice">Price</label>
                    <input type="text" name="productPrice" class="form-control" id="productPrice" placeholder="Product Price">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="productSellPrice">Sell Price</label>
                    <input type="text" name="productSellPrice" class="form-control" id="productSellPrice" placeholder="Product Sell Price">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="productDocument">Document</label>
                    <input type="file" name="productDocument" class="form-control ignour" id="productDocument">
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-12 mb-3">
                    <label for="productDescription">Description</label>
                    <textarea name="productDescription" class="form-control" id="productDescription" placeholder="Product Description"></textarea>
                </div>
            </div>
            <button class="btn btn-primary" id="addProduct" type="submit">Add</button>
        </form>
    </div>
</div>
<div id="ProductCatlog">
    <div class="modal-body">
        <p id="catlogError"></p>
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <strong>Info!</strong> You Have To Choice All Your Image At One Time.
        </div>
        <form action="#" method="POST" class="dropzone">
            <input type="hidden" id="spm_id" value="" />
            <div class="fallback">
                <input name="file" type="file" multiple />
            </div>
        </form>
    </div>
</div>