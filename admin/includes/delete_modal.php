<!-- Trigger the modal with a button
<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Modal</button> -->

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Confirm</h4>
      </div>
      <div class="modal-body">
        <h3>Are You sure You want to delete this post ?</h3>
      </div>
      <div class="modal-footer">
        <form method="post" action="posts.php?source=view_all">
          <input id="modal_id" type="hidden" name="delete" >


          <button type="submit" name="del_submit" class="btn btn-danger modal_delete_link">Delete</button>
          <button class="btn btn-default" data-dismiss="modal">Cancel</button>
        </form>
      </div>
    </div>

  </div>
</div>