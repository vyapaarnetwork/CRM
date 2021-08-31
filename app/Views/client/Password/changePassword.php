<div id="changePasswordPage" class="container">
    <div class="row">
        <div class="col-md-12">
            <h1 class="text-center mt-2">
                <b> Change Password</b>
            </h1>
        </div>
        <div class="col-md-4 offset-md-4">
            <form id="changePassword" class="p-4" method="POST">
                <input type="hidden" id="slug" value="<?php echo $user; ?>"/>
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <label for="fcpassword" style="color:black">New Password</label>
                        <input type="password" name="fcpassword" class="form-control" id="fcpassword" placeholder="New Password">
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <label for="frcpassword" style="color:black">Re-Enter Password</label>
                        <input type="password" name="frcpassword" class="form-control" id="frcpassword" placeholder="Re-Enter Password">
                    </div>
                </div>
                <button class="btn btn-info" type="submit">Submit</button>
            </form>
        </div>
    </div>
</div>