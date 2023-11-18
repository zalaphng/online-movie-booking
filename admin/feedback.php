<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v3.8.5">
    <title>Feedback Page</title>


    <?php session_start();
    if (!isset($_SESSION['admin'])) {
        header("location:login.php");
    }
    ?>
    <?php include_once("./templates/top.php"); ?>
    <?php include_once("./templates/navbar.php"); ?>
    <div class="container-fluid">
        <div class="row">

            <?php include "./templates/sidebar.php"; ?>

            <div class="row">
                <div class="col-10">
                    <h2>Feedback</h2>
                </div>
            </div>

            <?php
                include_once ('templates/error.php');
            ?>

            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Message</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody id="product_list">
                    <?php
                    require_once("../config/db_connect.php");
                    $result = mysqli_query($conn, "SELECT * FROM feedback");

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_array($result)) {
                            $id = $row['id']; ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo $row['name']; ?></td>
                                <td><?php echo $row['email']; ?></td>
                                <td><?php echo $row['message']; ?></td>
                                <td>
                                    <button data-toggle="modal" type="button"
                                            data-target="#delete_feedback_modal<?php echo $id; ?>"
                                            class="btn btn-danger btn-sm">Delete Feedback
                                    </button>
                                </td>
                            </tr>

                            <div class="modal fade" id="delete_feedback_modal<?php echo $row['id']; ?>" tabindex="-1"
                                 role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Delete Movie</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="delete-feedback" action="exec/feedback.php" method="post">
                                                <h4> Are you sure want to delete this ID "<?php echo $row['id']; ?>" ?</h4>
                                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                <input type="submit" name="delete-feedback" id="delete-feedback"
                                                       value="OK" class="btn btn-primary">
                                            </form>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php

                        }
                    } else {
                        echo "<tr><td colspan='12'>No records found</td></tr>";
                    }
                    ?>
                    </tbody>
                </table>
            </div>
            </main>
        </div>
    </div>


    <?php include_once("./templates/footer.php"); ?>


