<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    include 'header.php';
    ?>

    <div class="fractie-banner">
        <img src="assets/banner1.png" alt="deze afbeelding is niet beschikbaar" id="banner-fractie">
    </div>
    <div class="container-contact">
        <h1 class="title">Contact Formulier</h1>
        <div class="wrapper animated bounceInLeft">
            <div class="contact">
                <h3 class="contact-us">Contacteer Ons</h3>
                <div class="alert">Uw bericht is verstuurd!</div>
                <form id="contactForm">
                    <p class="name-field">
                        <label>Naam <span>*</span></label>
                        <input type="text" name="name" id="name" required>
                    </p>
                    <p class="company-field">
                        <label>Bedrijf</label>
                        <input type="text" name="company" id="company">
                    </p>
                    <p class="email-field">
                        <label>Email <span>*</span></label>
                        <input type="email" name="email" id="email" required>
                    </p>
                    <p class="phone-field">
                        <label>Telfoon</label>
                        <input type="text" name="phone" id="phone">
                    </p>
                    <p class="message-field full">
                        <label>Bericht</label>
                        <textarea name="message" rows="5" id="message"></textarea>
                    </p>
                    <p class="required-field">Verplicht veld <span>*</span></p>
                    <p class="submit-button">
                        <button type="submit">Verstuur</button>
                    </p>
                </form>
            </div>
        </div>
    </div>

    <?php
    include 'footer.php'
    ?>
</body>

</html>