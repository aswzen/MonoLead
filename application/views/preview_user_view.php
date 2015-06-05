<?php include('header.php'); ?>

<script type="text/javascript" src="<?php echo STATIC_DIR; ?>js/jquery.form.min.js"></script>

<div id="content" >

    <center>
    <div id="form_user" style="width: 750px;height:80%;margin-top:50px">
        <div class="w2ui-page page-0">
            <div style="width: 340px; float: left; margin-right: 0px;">
                <div style="padding: 3px; font-weight: bold; color: #777;">General</div>
                <div class="w2ui-group" style="height: 210px;">
                    <div class="w2ui-field w2ui-span4">
                        <label>ID:</label>
                        <div>
                            <input name="id" type="text" maxlength="100" style="width: 100%" readonly>
                        </div>
                    </div>
                    <div class="w2ui-field w2ui-span4">
                        <label>Full Name:</label>
                        <div>
                            <input name="fullname" type="text" maxlength="100" style="width: 100%" readonly>
                        </div>
                    </div>
                    <div class="w2ui-field w2ui-span4">
                        <label>Nick Name:</label>
                        <div>
                            <input name="nickname" type="text" maxlength="100" style="width: 100%" readonly>
                        </div>
                    </div>
                    <div class="w2ui-field w2ui-span4">
                        <label>Address:</label>
                        <div>
                            <textarea name="address" type="text" style="width: 100%; height: 50px; resize: none" readonly ></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div style="width: 380px; float: right; margin-left: 0px;">
                <div style="padding: 3px; font-weight: bold; color: #777;">Additional Information</div>
                <div class="w2ui-group" style="height: 210px;">
                    <div class="w2ui-field w2ui-span4">
                        <label>Email:</label>
                        <div>
                            <input name="email" type="text" maxlength="100" style="width: 100%" readonly />
                        </div>
                    </div>
                    <div class="w2ui-field w2ui-span4">
                        <label>Phone:</label>
                        <div>
                            <input name="phone" type="text" maxlength="100" style="width: 100%" readonly />
                        </div>
                    </div>
                    <div class="w2ui-field w2ui-span4">
                        <label>Other:</label>
                        <div>
                            <textarea name="other" type="text" style="width: 100%; height: 80px; resize: none" readonly></textarea>
                        </div>
                    </div>
                    <div class="w2ui-field w2ui-span4">
                        <label>Status:</label>
                        <div>
                            <input name="status" type="text" maxlength="100" style="width: 100%" readonly />
                        </div>
                    </div>
                </div>
            </div>
               
            <div style="width: 500px; float: left; margin-right: 0px;">
                <div class="w2ui-group" style="text-align:left;height: 30px;padding:0px">
                    <div class="w2ui-field w2ui-span4">
                        <label>Group:</label>
                        <div class="<?php echo $_USER_GROUP['icon']; ?>" style="width:20px;height:20px;padding-left:30px;line-height:20px">
                            <?php echo $_USER_GROUP['usergroup']; ?>
                        </div>
                    </div>
                </div>

                <div style="padding: 3px; font-weight: bold; color: #777;">Project member of</div>
                <div class="w2ui-group" style="text-align:left;padding:0px">
                    <div class="w2ui-span4">
                    <?php 
                        foreach ($_USER_PROJECT as $key => $value) {
                            echo '<div class="icon-box user-project" >'.$value['project_name'].'</div>';
                        }
                    ?>
                    </div>
                </div>
            </div>

            <div style="width: 220px; float: right; margin-left: 0px;">
                <div class="w2ui-group" style="height: 170px;border:1px solid #CEDCEA">
                    <div class="w2ui-field w2ui-span4">
                        <img id="profile_pic_image" src="<?php echo STATIC_DIR.$_USER_PROFILE_PIC; ?>" style="max-width:150px;max-height:150px;border:1px solid gray">
                    </div>
                </div>
            </div>

            <div style="clear: both; "></div>
        </div>
    </div>
    </center>

</div>

<?php include('footer.php'); ?>

<script type="text/javascript">
$(function () {
    $('#form_user').w2form({ 
        name   : 'form_user',
        header : 'User Profile',
        fields : [
            { field: 'id',  type: 'text' },
            { field: 'fullname',  type: 'text', required:true },
            { field: 'nickname',  type: 'text', required:true },
            { field: 'address',   type: 'text'},
            { field: 'email', type: 'email', required:true },
            { field: 'phone', type: 'text' },
            { field: 'password', type: 'text', required:true },
            { field: 'status', type: 'text' },
            { field: 'other', type: 'text' },
            { field: 'profile_pic_url', type: 'text' }
        ],
        record: <?php echo $_USER_DATA; ?>
    });
});


</script>