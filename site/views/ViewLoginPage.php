<?php

use Programster\AbstractView\AbstractView;

class ViewLoginPage extends AbstractView
{

    protected function renderContent()
    {
        ?>
        <form method="get" action="/login-with-google">
            <p>Click the button below to login with Google.</p>
            <input type="submit" value="Login With Google">
        </form>

        <?php
    }
}