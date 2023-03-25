<?php
$src = "data:image/png;base64," . base64_encode(file_get_contents(base_url('themes/default/img/email/dynamic.png')));
echo '<img src="' . $src . '" alt="Dynamic Dost" width="150" />';
echo '<img src="data:image/png;base64,' . base64_encode(file_get_contents(base_url('themes/default/img/email/shivatapes.png'))) . '" alt="Shiva Tapes" width="150" />';
echo '<img src="data:image/png;base64,' . base64_encode(file_get_contents(base_url('themes/default/img/email/indofila.png'))) . '" alt="Indofila" width="150" />';
?>
<p>
	<a href="www.dynamicdost.com" target="_blank">www.dynamicdost.com</a> / <a href="www.shivatapes.com" target="_blank">www.shivatapes.com</a> / <a href="www.indofila.com" target="_blank">www.indofila.com</a>
</p>