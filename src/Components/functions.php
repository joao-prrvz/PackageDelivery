<?php namespace PackageDelivery\Components; ?>
<?php function ErrorMessages(array $errors, string $key) { ?>
    <? foreach ($errors[$key] ?? []  as $error): ?>
        <div role="alert" class="alert alert-error alert-soft">
            <span><?= $error ?></span>
        </div>
    <? endforeach ?>
<? } ?>