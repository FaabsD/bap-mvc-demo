<?php $this->layout('registreer-inlog');?>
<?php $this->start('page_title')?>
    Registreren
<?php $this->stop()?>
<?php $this->start('header_content')?>
    <?php if ( isset ( $errors['email'] )): ?>
            <span class="error"><?php echo $errors['email']?></span>
    <?php endif ?>
    <?php if ( isset ( $errors['password'] )): ?>
            <span class="error"><?php echo $errors['password']?></span>
    <?php endif ?>
    <h2>
        Registreren
    </h2>
<?php $this->stop()?>
<?php $this->start('aside_content')?>
    <img src="<?php echo site_url('/images/Icon awesome-city.png')?>" alt="Stad illustratie">
<?php $this->stop()?>
<?php $this->start('main_content')?>
    <form action="<?php echo url("register.handle")?>" method="post">
        <input type="email" name="email" value ="<?php echo input('email') ?>"placeholder="E-mail adres">
        <input type="text" name="fullname" value="<?php echo input('fullname')?>"placeholder="Volledige naam">
        <input type="text" name="username" placeholder="Gebruikersnaam">
        <input type="password" name="password" placeholder="Wachtwoord">
        <input type="submit" value="Maak account aan">
    </form>
<?php $this->stop()?>