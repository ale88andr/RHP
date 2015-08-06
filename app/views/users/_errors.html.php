<? if(!empty($errors)): ?>
<p class="bg-danger" style="padding: 15px;">
    <strong>You made ​​the following errors:</strong><br>
    <? foreach($errors as $error): ?>
        <?= $error;?>
        <br>
    <? endforeach; ?>
</p>
<? endif; ?>