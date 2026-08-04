<?php
	if(empty($_title)) 			$_title ='';
	if(empty($_keywords)) 		$_keywords ='';
	if(empty($_description)) 	$_description ='';
?>
    <title>
        <?php echo $_title;?>
    </title>
    <meta name="keywords" content="<?php echo $_keywords;?>" />
    <meta name="description" content="<?php echo $_description;?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="robot" content="index, follow" />
    <meta name="generator" content="Brackets">
    <meta name='copyright' content='Orange Technology Solution co.,ltd.'>
    <meta name='designer' content='Netthakan O.'>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="css/layout.css"/>
    <link type="image/ico" rel="shortcut icon" href="images/favicon.ico">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.12.0/css/all.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.12.0/css/v4-shims.css">
    <link rel="stylesheet" href="fancybox-master/dist/jquery.fancybox.css" />
    <link rel="stylesheet" href="css/jquery-ui.css">

    
    <script src="js/jquery-3.3.1.slim.min.js"></script>
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery-ui.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.12.0/js/all.js"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.12.0/js/v4-shims.js"></script>
    <script src="fancybox-master/dist/jquery.fancybox.min.js"></script>
    
    <script type="text/javascript">
        $(document).ready(function () {

            $('.selectAll').click(function (e) {
                $(this).closest('table').find('td input:checkbox').prop('checked', this.checked);
            });
        });
    </script>