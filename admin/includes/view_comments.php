<h1 class="page-header">
    Comments
</h1>
<table class="table table-bordered table-hover">
    <thead>
        <tr class="info">
            <th>ID</th>
            <th>Author</th>
            <th>Post ID</th>
            <th>Email</th>
            <th>Status</th>
            <th>Date</th>
            <th>In Response To</th>
            <th>Approve</th>
            <th>Unapprove</th>
            <th colspan="2">Delete</th>
        </tr>
    </thead>
    <tbody>
        <?PHP
        showAllComments();
        commentApprovalSubmit();
        deleteCommentSubmit();
        ?>
    </tbody>   
</table>