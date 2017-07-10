<?php

$nl2brText = <<<EOT
Här kommer en radbrytning (enter).
Här kommer en till radbrytning.
Och en tredje.
Här är texten slut.
EOT;

$bbcodeText = "[I]Hej![/I] [b]Fetstil[/b] [u]Understruket[/u] [url]http://svd.se[/url]";

$clickableText = "http://hejsanhoppsan.se är en länk.";

$markdownText = <<<EOT
Detta blir en h2-rubrik
---------------------
### En lista:

*   Choklad
*   Havregryn
*   Vaniljsocker
EOT;

$nl2br = $app->textfilter->doFilter($nl2brText, "nl2br");
$bbcode = $app->textfilter->doFilter($bbcodeText, "bbcode");
$clickable = $app->textfilter->doFilter($clickableText, "clickable");
$markdown = $app->textfilter->doFilter($markdownText, "markdown");

?>
<div class="container textfilter">
<h1>Test av textfilter</h1>
<p>Nedan följer först oformaterad text, och sedan texten filtrerad.</p>

<h2>nl2br</h2>
<p>Ett filter som lägger till <code>&lt;br&gt;</code> när en rad bryts i en lång textsträng.</p>

<div class="input"> <?=$nl2brText;?></div>

<div class="output"> <?=$nl2br;?></div>

<h2>bbcode</h2>
<div class="input"><?=$bbcodeText;?></div>
<div class="output"><?=$bbcode;?></div>


<h2>link/clickable</h2>
<p>Clickable är ett filter som hittar länkar och gör dem klickbara.</p>
<div class="input"><?=$clickableText;?></div>
<div class="output"><?=$clickable;?></div>

<h2>markdown</h2>

<div class="input"><?=$markdownText;?></div>
<div class="output"><?=$markdown;?></div>



</div>
