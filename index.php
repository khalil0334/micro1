<?php require_once 'config/config.php';
    if(isset($_SESSION['country'])){
        $_SESSION['country'] = 'png';
        header('Location: '.login);
    }
?>

<!DOCTYPE html>
<html>
<head>
<!--<meta http-equiv="refresh" content="0;url=pages/index.html">-->
<title>Intelligent OutDailer</title>
<!--<script language="javascript">
    window.location.href = "pages/index.php"

</script>-->
    <link href="<?php echo assets; ?>css/customStyleSheet.css" rel="stylesheet">
</head>
<body id="index_body">
    <div class="Intro">
        <h1 class="cufon-m">Select right country</h1>

        <ul class="mainFlags">
            <li>
                <a href="pages/login.php?country=nauru" class="nauru">
                    <strong>Nauru</strong>
                </a>
            </li>
            <li>
                <a href="pages/login.php?country=png" class="png">
                    <strong>Papua New Guinea</strong>
                </a>
            </li>
            <li>
                <a href="pages/login.php?country=tonga" class="tonga">
                    <strong>Tonga</strong>
                </a>
            </li>
            <li>
                <a href="pages/login.php?country=vanuatu" class="vanuatu">
                    <strong>Vanuatu</strong>
                </a>
            </li>
            <li>
                <a href="pages/login.php?country=fiji" class="fiji">
                    <strong>Fiji</strong>
                </a>
            </li>
            <li>
                <a href="pages/login.php?country=samoa" class="samoa">
                    <strong>Samoa</strong>
                </a>
            </li>
            <li>
                <a href="pages/login.php?country=caribbean" class="caribbeanTT">
                    <strong>Trinidad & Tobago</strong>
                </a>
            </li>
        </ul>
    </div>
</body>
</html>
