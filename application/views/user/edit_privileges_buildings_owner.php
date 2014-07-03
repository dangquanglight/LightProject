<ol class="breadcrumb">
    <li><a href="<?php echo user_account_controller_url(); ?>">User Account Management</a></li>
    <li class="active">Manage user privileges</li>
</ol>

<div class="col-md-12">
    <?php for ($i = 0; $i < count($privileges); $i++): ?>
        <div class="table-responsive col-md-3">
            <table class="table table-hover">
                <tr>
                    <td>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" value="<?php echo $privileges[$i]['privilege_id'] ?>" checked>
                                <?php echo $privileges[$i]['building_name']; ?>
                            </label>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    <?php endfor; ?>
    <div class="col-sm-12">
        <button type="submit" class="btn btn-primary">Save</button>
        <button type="button" class="btn btn-default"
                onclick="window.location.href = '<?php echo user_account_controller_url(); ?>'">Cancel
        </button>
    </div>
</div>
