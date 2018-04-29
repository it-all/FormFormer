<?php
declare(strict_types=1);

class Template
{
    private $form;
    private $headMeta='';
    private $headCss='';
    private $headJs='';
    private $bodyContent='';
    private $bodyJs='';

    public function __construct(?\It_All\FormFormer\Form $form = null)
    {
        if ($form !== null) {
            $this->form = $form;
            $this->setBodyContent($form->generate());

            $focusFieldId = $form->getFocusFieldId();
            if (strlen($focusFieldId) > 0) {
                $bodyJs = <<< EOL
<script type="text/javascript">
    window.onload = document.getElementById('$focusFieldId').focus();
</script>
EOL;
                $this->setBodyJs($bodyJs);
            }
        }
    }

    public function setHeadMeta(string $headMeta)
    {
        $this->headMeta = $headMeta;
    }

    public function setHeadCss(string $headCss)
    {
        $this->headCss = $headCss;
    }

    public function setHeadJs(string $headJs)
    {
        $this->headJs = $headJs;
    }

    public function setBodyContent(string $bodyContent)
    {
        $this->bodyContent = $bodyContent;
    }

    public function setBodyJs(string $bodyJs)
    {
        $this->bodyJs = $bodyJs;
    }

    public function setFocusFieldAsBodyJs(string $focusFieldId)
    {

    }

    public function render()
    {
        echo <<< EOL
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>FormFormer</title>
    <meta name="author" content="it-all.com">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="html forms, html5 forms">
    <meta name="description" content="FormFormer is an HTML form generation tool written in PHP by it-all.com">
    $this->headMeta
    <link rel="stylesheet" href="css/ffstyle.css?v=3.8">
    $this->headCss
    $this->headJs
</head>
<body>
$this->bodyContent
$this->bodyJs
</body>
</html>
EOL;

    }
}

