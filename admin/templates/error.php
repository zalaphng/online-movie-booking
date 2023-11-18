<?php

if (isset($_GET['msg']) && (isset($_GET['error']))) {

    $msg = $_GET['msg'];
    $error = $_GET['error'];

?>
    <div class="alert <?php echo ($error == 0) ? 'alert-success' : 'alert-danger'; ?> alert-dismissible fade show mt-3" role="alert">
        <?php echo $msg; ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php } ?>