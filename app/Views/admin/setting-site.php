<div class="page-container">
    <?php echo $adminMenu; ?>
    <div class="main-content-inner">
        <div class="row">
            <div class="col-lg-12 mt-3">
                <div class="card">
                    <div class="card-body">
                        <button type="button" id="editData" class="btn btn-primary">
                            Add New Setting
                        </button>
                    </div>
                </div>
            </div>
            <!-- table primary start -->
            <div class="col-lg-12 mt-3">
                <span id="errorReturn"></span>
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Settings</h4>
                        <div class="single-table">
                            <div class="table-responsive">
                                <table id="adminTableList" class="table text-center">
                                    <thead class="text-uppercase bg-primary">
                                        <tr class="text-white">
                                            <th scope="col">Name</th>
                                            <th scope="col">Setting Key</th>
                                            <th scope="col">Setting Type</th>
                                            <th scope="col">Setting Value</th>
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
<div id="newSetting">
    <div class="modal-body">
        <p id="resultMessage"></p>
        <form method="POST" id="settingData" novalidate>
            <input type="hidden" name="ssm_id" id="ssm_id" value="">
            <div class="form-row">
                <div class="col-md-4 mb-3">
                    <label for="fName">Setting Name</label>
                    <input type="text" name="Name" class="form-control" id="Name" placeholder="Setting Name">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="fName">Setting Key</label>
                    <input type="text" name="Key" class="form-control" id="Key" placeholder="Setting Key">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="type">Setting Type</label>
                    <select name="type" class="form-control required" id="type">
                        <option value="">Select</option>
                        <option value="Textbox">Text Box</option>
                        <!-- <option value="Radiobutton">Radio Button</option> -->
                        <option value="Checkbox">Checkbox</option>
                        <option value="Textarea">Textarea</option>
                        <option value="File">File</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div id="tBox" class="col-md-12 mb-3" style="display: none;">
                    <div class="form-group">
                        <label for="textbox" class="col-form-label" id="tBoxName"></label>
                        <input class="form-control" name="textbox" value="" type="text" id="tBoxValue">
                    </div>
                </div>
                <div id="tArea" class="col-md-12 mb-3" style="display: none;">
                    <div class="form-group">
                        <label for="textarea" class="col-form-label" id="tAreaName"></label>
                        <textarea class="form-control" name="textarea" type="text" id="tAreaValue" rows="3"></textarea>
                    </div>
                </div>
                <div id="cBox" class="col-md-12 mb-3" style="display: none;">
                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" name="checkbox" id="cBoxValue">
                        <label class="form-check-label" id="cBoxName" for="checkbox"></label>
                    </div>
                </div>
                <div id="file" class="col-md-12 mb-3" style="display: none;">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span id="fileName" class="input-group-text"></span>
                        </div>
                        <div class="custom-file">
                            <input type="file" name="newFile" class="custom-file-input" id="newFile">
                            <label class="custom-file-label" for="fille">Choose file</label>
                            <input type="hidden" value="fileValue" name="oldFile" id="oldFile" />
                        </div>
                    </div>
                </div>
            </div>
            <button class="btn btn-primary mb-3" id="addNewKey" type="submit">Add</button>
        </form>
    </div>
</div>