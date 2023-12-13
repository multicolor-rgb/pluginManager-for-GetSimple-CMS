<h3>Uninstall plugins</h3>

<style>
	.plugin-uni {
		display: grid;
		list-style-type: none;
		margin: 0 !important;
		padding: 0 !important;
		width: 100%;
		box-sizing: border-box;
	}

	.plugin-uni li {
		display: flex;
		padding: 10px;
		justify-content: space-between;
		box-sizing: border-box;
		align-items: center;
		border-bottom: solid 1px #ddd !important;
	}

	.plugin-uni li:nth-child(2n) {
		background: #fafafa;
	}

	.plugin-uni a {
		background: red;
		color: #fff !important;
		text-decoration: none !important;
		padding: 10px;
		border-radius: 5px;
	}
</style>

<ul class="plugin-uni">
	<?php
	global $GSADMIN;
	global $SITEURL;
	$url =  $SITEURL . $GSADMIN . '/load.php?id=pluginManager&removeplugins';

	foreach (glob(GSPLUGINPATH . '*.php') as $file) {

		$filename = pathinfo($file)['filename'];
		echo '
		<li>
			<p>' . $filename . '</p>
			<a href="' . $url . '&delPlugin=' . $filename . '" onclick="return confirm(`You want to uninstall ' . $filename . '?`);">Delete</a>
		</li>';
	};
	?>
</ul>

<?php if (isset($_GET['delPlugin'])) {

	function unistaller()
	{
		$delPlug = $_GET['delPlugin'];

		function delete_directory($dirname)
		{
			if (file_exists($dirname)) {
				if (is_dir($dirname))
					$dir_handle = opendir($dirname);
				if (!$dir_handle)
					return false;
				while ($file = readdir($dir_handle)) {
					if ($file != "." && $file != "..") {
						if (!is_dir($dirname . "/" . $file))
							unlink($dirname . "/" . $file);
						else
							delete_directory($dirname . '/' . $file);
					}
				}
				closedir($dir_handle);
				rmdir($dirname);
				return true;
			}
		};

		if (GSPLUGINPATH . $delPlug) {
			delete_directory(GSPLUGINPATH . $delPlug);
		};

		if (file_exists(GSPLUGINPATH . $delPlug . '.php')) {
			unlink(GSPLUGINPATH . $delPlug . '.php');
		}

		global $GSADMIN;
		global $SITEURL;
		$url =  $SITEURL . $GSADMIN . '/load.php?id=pluginManager&removeplugins';

		echo '<div class="success" style="position:absolute; top:0; left:0; width: 100%; background: green; padding: 10px; box-sizing: border-box; color: #fff; margin-bottom: 20px;">Removed!</div>';

		echo ("<script>
		setTimeout(()=>{
			window.location.href = '" . $url . "';
		},1000);
		</script>");
	}

	unistaller();
}; ?>

<br>
<br>
<style>
	.kofi-button{ 
		text-decoration: unset !important;
	}
	</style>
<script type='text/javascript' src='https://storage.ko-fi.com/cdn/widget/Widget_2.js'></script>
<script type='text/javascript'>
	kofiwidget2.init('Support Me on Ko-fi', 'red', 'I3I2RHQZS');
	kofiwidget2.draw();
</script>