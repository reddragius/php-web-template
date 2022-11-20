<?php
$error = [];
$name = "";
$phone = "";
$email = "";
$message = "";
$send = false;

if (array_key_exists("submit", $_POST))
{
    // formular byl odeslan
    $name = $_POST["name"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];
    $message = $_POST["message"];

    // validace hodnot
    if (mb_strlen($name) < 5)
    {
        $error["name"] = "Jméno musí být zadáno";
    }
    if (mb_strlen($phone) < 9)
    {
        $error["phone"] = "Telefon musí být zadán";
    }
    if (!preg_match("/.+@.+\\..+/", $email))
    {
        $error["email"] = "Neplatný email";
    }
    if (mb_strlen($message) < 5)
    {
        $error["message"] = "Zpráva musí být zadána";
    }

    // zkontrolovat pole chyb
    if (count($error) == 0)
    {
        // vse ok
        $send = true;

        // odeslat email spravci
        $mail = new PHPMailer\PHPMailer\PHPMailer(true);

        $mail->CharSet = "utf-8";

        $mail->setFrom('info@example.com', 'Example');
        $emailAddress = $shortcode->getParameter("email");
        $mail->addAddress($emailAddress);

        $mail->isHTML(true);
        $mail->Subject = 'Kontaktní formulář BistroLaza';
        $mail->Body = "
            <h1>Kontaktní formulář BistroLaza</h1>
            <div><b>Jméno:</b> $name</div>
            <div><b>Telefon:</b> $phone</div>
            <div><b>Email:</b> $email</div>
            <div><b>Zpráva:</b> $message</div>
        ";
        $mail->send();
    }
}
?>

<div class="form" id="kontaktni-form"><!-- scroll back after send -->
    <?php if ($send == false) { ?>
        <form method="post" action="#kontaktni-form"> 
                <input type="text" name="name" placeholder="Jméno" value="<?php echo htmlspecialchars($name) ?>" />
                <?php
                if (array_key_exists("name", $error))
                {
                    echo "<div class='alert'>{$error['name']}</div>";
                }
                ?>
                <input type="text" name="phone" placeholder="Příjmení" value="<?php echo htmlspecialchars($phone) ?>" />
                <?php
                if (array_key_exists("phone", $error))
                {
                    echo "<div class='alert'>{$error['phone']}</div>";
                }
                ?>
                <input type="text" name="email" placeholder="E-mail" value="<?php echo htmlspecialchars($email) ?>"/>
                <?php
                if (array_key_exists("email", $error))
                {
                    echo "<div class='alert'>{$error['email']}</div>";
                }
                ?>
                <textarea name="message" placeholder="Zanechte nám vzkaz"><?php echo htmlspecialchars($message) ?></textarea>
                <?php
                if (array_key_exists("message", $error))
                {
                    echo "<div class='alert'>{$error['message']}</div>";
                }
                ?>
                <input type="submit" name="submit" value="Odeslat" />
        </form>
    <?php } else { ?>
        <p>Kontaktní formulář byl odeslán.</p> 
        <h2>Těšíme se na Vaši návštěvu brzy naviděnou.</h2>
    <?php } ?>
</div>