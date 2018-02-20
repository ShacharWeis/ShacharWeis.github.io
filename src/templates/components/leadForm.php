<form method="post" id="contactForm" action="<?php echo '/app/submit.php'; ?>">

    <?php
    $response = $session->getFlashBag()->get('response');
    foreach($response as $key => $value) :
        ?>
        <div class="notifications">
            <p><?php echo $value; ?></p>
        </div>
    <?php endforeach; ?>

    <?php $errors = $session->getFlashBag()->get('validation'); ?>
    <?php $flashData = $session->getFlashBag()->get('data') ?? []; ?>
    <input type="hidden" name="csrfToken" value="<?php echo $token; ?>"/>
    <input type="hidden" name="website" value=""/>
    <div class="field">
        <label for="name">Name</label>
        <input type="text" name="name" id="name"
               value="<?php if(!empty($flashData['form']['name'])) { echo $flashData['form']['name']; } ?>"/>
        <span><?php if(!empty($errors['validation']['name'])) { echo $errors['validation']['name']; } ?></span>
    </div>
    <div class="field">
        <label for="email">Email</label>
        <input type="email" name="email" id="email"
               value="<?php if(!empty($flashData['form']['email'])) { echo $flashData['form']['email']; } ?>"/>
        <span><?php if(!empty($errors['validation']['email'])) { echo $errors['validation']['email']; } ?></span>
    </div>
    <div class="field">
        <label for="message">Message</label>
        <textarea name="message" id="message"
                  rows="4"><?php if(!empty($flashData['form']['message'])) { echo $flashData['form']['message']; } ?></textarea>
        <span><?php if(!empty($errors['validation']['message'])) { echo $errors['validation']['message']; } ?></span>
    </div>
    <ul class="actions">
        <li><input type="submit" value="Contact Packet39"/></li>
    </ul>
</form>
