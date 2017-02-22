<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
* Layout: head.php
*/
$data = (isset($data) && $data ? $data : false);
$this->load->view('layout/seo', array('data' => $data));

if(isset($data['styles']) && $data['styles'] && count($data['styles']) > 0){
	foreach($data['styles'] as $path){ ?>
		<link href="<?php echo $path; ?>?<?php echo time(); ?>" rel="stylesheet" />
	<?php }
}
?>
<script>
var D_VARS = {
	base_url: '<?php echo site_url(); ?>',
	ajax_url: '<?php echo site_url('ajax'); ?>',
};
var LANGS = JSON.parse('<?php echo addslashes(json_encode($this->lang->language)); ?>');
</script>
<?php
if(isset($data['scripts']) && $data['scripts'] && count($data['scripts']) > 0){
	foreach($data['scripts'] as $path){ ?>
		<script src="<?php echo $path; ?>?<?php echo time(); ?>"></script>
	<?php }
}