<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
* Layout: footer.php
*/
$data = (isset($data) && $data ? $data : false);
?>
			</div>
		</section>
		<footer id="footer">
			<div class="container footer-inner">
				Footer
			</div>
		</footer>
	</div>
	<?php
	if($this->layout->footer_scripts && count($this->layout->footer_scripts) > 0){
		foreach($this->layout->footer_scripts as $script_code){
			echo '<script type="text/javascript">'.$script_code.'</script>';
		}
	} ?>
</body>
</html>