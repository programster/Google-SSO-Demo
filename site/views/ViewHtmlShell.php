<?php

use Programster\AbstractView\AbstractView;

class ViewHtmlShell extends AbstractView
{
    public function __construct(private readonly string|Stringable $body)
    {

    }


    protected function renderContent()
    {
?>

<!DOCTYPE html>
<html>
<head>
    <title>Google Login Demo</title>
    <meta name="description" content="description"/>
    <meta name="author" content="author" />
    <meta name="keywords" content="keywords" />
    <style type="text/css">.body { width: auto; }</style>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>
<body><?= (string)$this->body; ?>
</body>
</html>

<?php
    }
}