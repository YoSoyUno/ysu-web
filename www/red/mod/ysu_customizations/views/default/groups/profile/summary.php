<?php
/**
 * Group profile summary
 *
 * Icon and profile fields
 *
 * @uses $vars['group']
 */

if (!isset($vars['entity']) || !$vars['entity']) {
	echo elgg_echo('groups:notfound');
	return true;
}

$group = $vars['entity'];
$owner = $group->getOwnerEntity();

if (!$owner) {
	// not having an owner is very bad so we throw an exception
	$msg = "Sorry, '" . 'group owner' . "' does not exist for guid:" . $group->guid;
	throw new InvalidParameterException($msg);
}

?>

<?php

$tipo = elgg_echo('ysu:punto:'.$group->tipo);
$title = $group->name;
$description = $group->description;
$briefdescription = $group->briefdescription;
$num_members = $group->getMembers(array('count' => true));
$google_api_key = elgg_get_plugin_setting('google_api_key', 'amap_maps_api');
$lat = $group->getLatitude();
$long = $group->getLongitude();
$coord = elgg_echo('ysu:punto:coord');

if (!strpos($group->getIconURL('master'),'defaultmaster')) {
	$banner = $group->getIconURL('master');
} else {
	$banner = "https://api.mapbox.com/v4/mapbox.satellite/{$long},{$lat},9/700x300@2x.png?access_token=pk.eyJ1IjoiaWFjb21lbGxhIiwiYSI6ImNpdWJ3OHJoYTAwOHgyb3BneWd1NG16bjgifQ.8uFt1oMO57yDT9Xzb_ScAw";
}


$group_details = "<div class='mbm elgg-border-plain group-banner' style='background-image:url(\"$banner\")'>

<h3>{$tipo}</h3>
<h2>{$title}</h2>
<div class='group-banner-minimap' title='{$coord}: {$lat},{$long}' style='background-image:url(https://maps.googleapis.com/maps/api/staticmap?center={$lat},{$long}&zoom=0&scale=false&size=100x130&maptype=satellite&format=png&visual_refresh=true&markers=size:small%7Ccolor:0xff0000%7Clabel:%7C{$lat},{$long}&key={$google_api_key});'></div>
<span>{$briefdescription}</span>

</div>";
echo $group_details;
echo '<div class="group-banner-description">';
?>

<p class='group-banner-owner' <?php if (elgg_is_admin_user($owner->getGUID())) { echo "style='display:none;'";} ?>>
	<b><?php echo elgg_echo("groups:owner"); ?>: </b>
	<?php
		echo elgg_view('output/url', array(
			'text' => $owner->name,
			'value' => $owner->getURL(),
			'is_trusted' => true,
		));
	?>
</p>
<?php
if ($group->description != '') {
	echo '<h3>'.elgg_echo('ysu:punto:detalles').'</h3>';
	echo $description;
}
echo '</div>';

?>
