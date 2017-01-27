<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
        <link rel="apple-touch-icon" sizes="76x76" href="../content/img/apple-icon.png" />
        <link rel="icon" type="image/png" href="../content/img/favicon.png" />
        <title>AURORA</title>
        <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
        <meta name="viewport" content="width=device-width" />
        <!-- Bootstrap core CSS -->
        <?= link_tag("template/css/bootstrap.min.css") ?>
        <!--  Material Dashboard CSS    -->
        <?= link_tag("template/css/material-dashboard.css") ?>
        <!--  CSS for Demo Purpose, don't include it in your project     -->
        <?= link_tag("template/css/demo.css") ?>
        <!--     Fonts and icons     -->
        <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
        <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300|Material+Icons' rel='stylesheet' type='text/css'>
        <script> var base = "<?= base_url() ?>"</script>
        <script src="<?= base_url("template/js/base.js") ?>"></script>

    </head>

    <body>
        <div class="wrapper">
            <div class="sidebar" data-color="blue" data-image="<?= base_url("template/img/sidebar-1.jpg") ?>">
                <!--
                Tip 1: You can change the color of the sidebar using: data-color="purple | blue | green | orange | red"

                Tip 2: you can also add an image using data-image tag
                -->

                <div class="logo">
                    <a href="#" class="simple-text">
                        Aurora
                    </a>
                </div>

                <div class = "sidebar-wrapper">
                    <ul class = "nav">
                        <li class = "active">
                            <a href = "<?= base_url() ?>">
                                <i class = "material-icons">library_music</i>
                                <p>Agrega Canciones</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class = "main-panel">
                <nav class = "navbar navbar-transparent navbar-absolute">
                    <div class = "container-fluid">
                        <div class = "navbar-header">
                            <button type = "button" class = "navbar-toggle" data-toggle = "collapse">
                                <span class = "sr-only">Toggle navigation</span>
                                <span class = "icon-bar"></span>
                                <span class = "icon-bar"></span>
                                <span class = "icon-bar"></span>
                            </button>
                            <a class = "navbar-brand" href = "#"><? = $nombreSeccion
                                ?></a>
                        </div>
                    </div>
                </nav>
                <div class="content">
                    <?= $contenido ?>
                </div>
                <footer class="footer">
                    <div class="container-fluid">
                        <nav class="pull-left">
                            <ul>
                                <li>
                                    <a href = "<?= base_url() ?>">
                                        Agregar Canciones
                                    </a>
                                </li>
                                <li>
                                    <a href = "<?= base_url("index.php/Reproductor") ?>">
                                        Reproductor
                                    </a>
                                </li>
                            </ul>
                        </nav>
                        <p class="copyright pull-right">
                            &copy; <script>document.write(new Date().getFullYear())</script> <a href="https://soundcloud.com/ONNAV">Oscar Navarro</a>, made with love for a better web
                        </p>
                    </div>
                </footer>
            </div>
        </div>

    </body>

    <!--   Core JS Files   -->
    <script src="<?php echo base_url("template/js/jquery-3.1.0.min.js") ?>" type="text/javascript"></script>
    <script src="<?php echo base_url("template/js/bootstrap.min.js") ?>" type="text/javascript"></script>
    <script src="<?php echo base_url("template/js/material.min.js") ?>" type="text/javascript"></script>
    <!--  Notifications Plugin    -->
    <script src="<?php echo base_url("template/js/bootstrap-notify.js") ?>"></script>
    <script src="<?= base_url("template/js/demo.js") ?>"></script>
    <!-- Material Dashboard javascript methods -->
    <script src="<?= base_url("template/js/material-dashboard.js") ?>"></script>
    <!--    
             Material Dashboard DEMO methods, don't include it in your project! 
            <script src="content/js/demo.js"></script>-->
    <script>type = ['', 'info', 'success', 'warning', 'danger'];</script>
</html>
