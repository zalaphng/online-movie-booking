  <?php
session_start();
?>


<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Male_Fashion Template">
    <meta name="keywords" content="Male_Fashion, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Contact Page</title>

    <?php
        include_once ('templates/styles.php')
    ?>
</head>

<body>
    <?php
    include("templates/header.php");
    ?>

    <!-- Contact Section Begin -->
    <section class="contact spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="contact__text">
                        <div class="section-title">
                            <span>Information</span>
                            <h2>Contact Us</h2>
                            <p>As you might expect of a company that began as a high-end interiors contractor, we pay
                                strict attention.</p>
                        </div>
                        <ul>
                            <li>
                                <h4>Azir Cinema</h4>
                                <p>Nha Trang, Khanh Hoa.  <br />+84 123-456-7890
                                    <br />+84 123-456-7890</p>
                            </li>
                        
                        </ul>
                    </div>
                </div>
                
            </div>
        </div>
    </section>
    <!-- Contact Section End -->

    <!-- Footer Section Begin -->
    <?php
        include("templates/footer.php");
    ?>

</body>

</html>
