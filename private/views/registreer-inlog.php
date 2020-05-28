<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo site_url('/css/aanmelding.css')?>" media="all">
    <title><?php echo $this->section('page_title');?></title>
</head>
<body>
    <nav>
        <h1>DRUKTEZOEKER</h1>
    </nav>
    <header>
        <?php echo $this->section('header_content');?>
    </header>
    <aside>
        <?php echo $this->section('aside_content');?>
    </aside>
    <main>
        <?php echo $this->section('main_content');?>
    </main>  
</body>
</html>