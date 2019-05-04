<h1 class="page-header">
    Users
</h1>
<table class="table table-bordered table-hover">
    <thead>
    <tr class="info">
            <th>ID</th>
            <th>User Name</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Created At</th>
            <th colspan="2">Roles</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
        <?PHP showAllUsers(); ?>

        <?PHP 
        changeRoleSubmit();
        deleteUserSubmit();
        ?>
    </tbody>   
</table>