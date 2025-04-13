<?php

use Programster\AbstractView\AbstractView;

class ViewHomePage extends AbstractView
{
    public function __construct(private readonly string $userEmail)
    {

    }

    protected function renderContent()
    {
?>
        <p>Hello <?= $_SESSION['USER_FIRST_NAME'] . " " . $_SESSION['USER_LAST_NAME'] . " with email: " . $_SESSION['USER_EMAIL']; ?></p>
<?php
    }
}