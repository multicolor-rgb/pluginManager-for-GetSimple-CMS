<style>
	@import url("<?php global $SITEURL;
					echo $SITEURL . 'plugins/pluginManager/css/downloader.css'; ?>");
</style>

<h3 style="margin-bottom:0;">Plugin Downloader</h3>
<a href="https://getsimplecms-ce-plugins.github.io/" target="_blank" style="margin-bottom:20px;margin-top:10px;display:block;">Based on the Get Simple CMS CE plugin repository.</a>

<input type="text" class="searchce" placeholder="Search plugins...">
<?php
global $GSADMIN;

$db = file_get_contents('https://getsimplecms-ce-plugins.github.io/db.json');
$jsondb = json_decode($db);

global $SITEURL;

echo '<ul class="db-list">';

foreach ($jsondb as $key => $value) {
	echo '
	<li><b class="title">' . $value->name . '</b>
		<p class="info">' . $value->info . '</p>
		<hr>
		<p class="version"><b>Version:</b> ' . $value->version . '</p>
		<p class="author">' . $value->author . '</p>
		<form action="#" method="POST">
			<input type="hidden" name="url" value="' . $value->url . '">
			<input type="submit" name="download" class="download" value="Download">
		</form>
	</li>
	';
}

echo '</ul>'; ?>

<?php
if (isset($_POST['download'])) {
	function downloadPlugin()
	{
		function delete_directory($dirname)
		{
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
		};

		$url = $_POST['url'];

		file_put_contents(GSPLUGINPATH . "Tmpfile.zip", fopen("$url", 'r'));
		$path = GSPLUGINPATH . "Tmpfile.zip";

		$zip = new ZipArchive;
		if ($zip->open($path) === TRUE) {
			if (file_exists(GSPLUGINPATH . "tmp_plugin/") == false) {
				mkdir(GSPLUGINPATH . "tmp_plugin/", 0755);
			};
			$zip->extractTo(GSPLUGINPATH  . "tmp_plugin/");
			$zip->close();

			foreach (glob(GSPLUGINPATH  . "tmp_plugin/*/*") as $filename) {
				if (file_exists(str_replace(pathinfo($filename)['dirname'], GSPLUGINPATH, $filename))) {
					delete_directory(str_replace(pathinfo($filename)['dirname'], GSPLUGINPATH, $filename));
				}
				rename($filename, str_replace(pathinfo($filename)['dirname'], GSPLUGINPATH, $filename));
			};

			delete_directory(GSPLUGINPATH . "tmp_plugin");

			unlink($path);
		};

		echo '<div class="success" style="position:absolute;top:0;left:0;">Installed!</div>';
		echo ("<meta http-equiv='refresh' content='1'>");
	}

	downloadPlugin();
};
?>

<script>
	document.querySelector('.searchce').addEventListener('keyup', (e) => {
		document.querySelectorAll('.db-list li').forEach(
			x => {
				x.style.display = "none";
			}
		);

		document.querySelectorAll('.db-list li').forEach(c => {
			if (c.querySelector('.title').innerHTML.toLowerCase().indexOf(document.querySelector('.searchce').value.toLowerCase()) > -1) {
				c.style.display = "block";
			}
		})
	});
</script>
<br>
<br>
<style>
	.kofi-button{ 
		text-decoration: unset !important;
	}
	</style>

<script type='text/javascript' src='https://storage.ko-fi.com/cdn/widget/Widget_2.js'></script><script type='text/javascript'>kofiwidget2.init('Support Me on Ko-fi', 'red', 'I3I2RHQZS');kofiwidget2.draw();</script> 