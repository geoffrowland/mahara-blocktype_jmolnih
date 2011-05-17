<?php
/**
 * Mahara: Electronic portfolio, weblog, resume builder and social networking
 * Copyright (C) 2006-2009 Catalyst IT Ltd and others; see:
 *                         http://wiki.mahara.org/Contributors
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @package    mahara
 * @subpackage blocktype-jmolnih
 * @author     Geoffrey Rowland
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL
 * @copyright  (C) 2011 Geoffrey Rowland, geoff.rowland@yeovil.ac.uk
 *
 * This plugin depends on the NIH NCI/CADD Chemical Identifier Resolver
 * http://cactus.nci.nih.gov/chemical/structure
 *
 * It also uses the Jmol Java applet for interactive 3D rendering of
 * chemical dtructures
 * http://jmol.sf.net
 */

defined('INTERNAL') || die();

class PluginBlocktypeJmolNih extends SystemBlocktype {

    public static function get_title() {
        return get_string('title', 'blocktype.jmolnih');
    }

    public static function get_description() {
        return get_string('description', 'blocktype.jmolnih');
    }

    public static function get_categories() {
        return array('feeds');
    }

    public static function render_instance(BlockInstance $instance, $editing=false) {
        $configdata = $instance->get('configdata');
        $jmolnihid = clean_html(trim($configdata['jmolnihid']));
        $jmolnihid = preg_replace('/\s+/', ' ', $jmolnihid);
        // urlencode search string: replace ' ' with %20, # with %23 etc
        $jmolnihid2 = rawurlencode($jmolnihid);

        $width   = (!empty($configdata['width'])) ? hsc($configdata['width']) : '300';
        $height  = (!empty($configdata['height'])) ? hsc($configdata['height']) : '300';
        $jmolscript  = (!empty($configdata['jmolscript'])) ? clean_html($configdata['jmolscript']) : null;
        $initscript = str_replace('"', "'", str_replace("\n", "", trim($jmolscript)));
        $controlscript  = (!empty($configdata['controlscript'])) ? clean_html($configdata['controlscript']) : null;
        $controls = str_replace('"', "'", str_replace("\n", "", trim($controlscript)));
        $nih = 'http://cactus.nci.nih.gov/chemical/structure/';
		
        if (isset($configdata['jmolnihid'])) {
           	$context = stream_context_create(array(
                'http' => array(
                    'timeout' => 5      // Timeout in seconds
                )
            ));
            $sdf = '';
            $sdf = @file_get_contents($nih.$jmolnihid2.'/sdf?get3d=true', 0, $context);
            // Check for empties
            if (!empty($sdf)) {
                // Retrieve HTTP status code
                list($version,$status_code,$msg) = explode(' ',$http_response_header[0], 3);
                // Check the HTTP Status code
                if($status_code == 200) {
		              // Success
                    // Fix line endings, quotes etc
                    $search = array("\r\n", "\r", "\n", '"');
                    $replace = array("\n", "\n", "\\n", "'");
                    $sdf = str_replace($search, $replace, $sdf);
                    $result  = '';
                    $result .= self::get_js_source();
                    $result .= '<div style="text-align: center; width: '.$width.'px">';
                    $result .= '<a target="blank" title="'.get_string('download','blocktype.jmolnih').'" href ="'.$nih.$jmolnihid2.'/sdf?get3d=true">'.$jmolnihid.'</a>';
    	              $result .= '<div style="border: 1px solid lightgrey; width: '.$width.'px">';
    	              $result .= '<script type="text/javascript">jmolSetAppletColor("white")</script>';
    	              $result .= '<script type="text/javascript">jmolAppletInline(['.$width.','.$height.'], "'.$sdf.'", "set antialiasDisplay true; '.$initscript.'")</script>';
                    $result .= '</div>';
                    $result .= '<div style="text-align: left">';
                    $result .= '<script type="text/javascript">'.$controls.'</script>';
                    $result .= '</div>';
                    $result .= '</div>';
                }elseif($status_code == 404){
            	     $result='<div>NIH service request not resolvable</div>';
                }elseif($status_code == 500){
            	     $result='<div>NIH service error</div>';
                }else{
            	     $result='<div>NIH service not available</div>';
                }
            }else{
                $result='<div>NIH service not available</div>';
            }	 
        }

        return $result;
    }

    public static function has_instance_config() {
        return true;
    }

    public static function instance_config_form($instance) {
        $configdata = $instance->get('configdata');
        $defaultloadscript = '';
        $defaultcontrolscript = '
jmolMenu([
["#optgroup", "Style"],
["wireframe only", "Wireframe"],
["spacefill off; wireframe 0.15", "Stick"],
["wireframe 0.15; spacefill 23%", " Ball and stick", "selected"],
["spacefill on", "Spacefill"],
["#optgroupEnd"]
],"","","Display style");
jmolHtml(" ");
jmolCheckbox("set showHydrogens on", "set showHydrogens off", "Hydrogens", "checked","","Show/hide hydrogen atoms");
jmolHtml(" ");
jmolCheckbox("spin on", "spin off", "Spin", "", "", "Toggle spin on/off");
';
        return array(
            'jmolnihid' => array(
                'type'  => 'text',
                'size'  => 50,
                'title' => get_string('jmolnihsearch','blocktype.jmolnih'),
                'description' => get_string('jmolnihsearchdescription2','blocktype.jmolnih')
		  . '<br>' . get_string('jmolnihsearchpatterns','blocktype.jmolnih'),
                'defaultvalue' => isset($configdata['jmolnihid']) ? $configdata['jmolnihid'] : null,
                'rules' => array(
                    'required' => true,
                ),
            ),
            'width' => array(
                'type' => 'text',
                'title' => get_string('width','blocktype.jmolnih'),
                'size' => 3,
                'rules' => array(
                    'minvalue' => 100,
                    'maxvalue' => 1000,
                ),
                'defaultvalue' => (!empty($configdata['width'])) ? $configdata['width'] : '300',
            ),
            'height' => array(
                'type' => 'text',
                'title' => get_string('height','blocktype.jmolnih'),
                'size' => 3,
                'rules' => array(
                    'minvalue' => 100,
                    'maxvalue' => 1000,
                ),
                'defaultvalue' => (!empty($configdata['height'])) ? $configdata['height'] : '300',
            ),
            'jmolscript' => array(
                'type' => 'textarea',
                'title' => get_string('jmolscript','blocktype.jmolnih'),
                'description' => get_string('jmolscriptdescription','blocktype.jmolnih'),
                'rows' => 5,
                'cols' => 60,
                'defaultvalue' => isset($configdata['jmolscript']) ? $configdata['jmolscript'] : $defaultloadscript
            ),
             'controlscript' => array(
                'type' => 'textarea',
                'title' => get_string('controlscript','blocktype.jmolnih'),
                'description' => get_string('controlscriptdescription','blocktype.jmolnih'),
                'rows' => 5,
                'cols' => 60,
                'defaultvalue' => isset($configdata['controlscript']) ? $configdata['controlscript'] : $defaultcontrolscript
            ),
        );
    }

    public static function instance_config_save($values) {
        if ($values['jmolnihid']) {
			$values['jmolnihid'] = $values['jmolnihid'];
		}
        return $values;
    }

//  Jmol.js only called once
    private static function get_js_source() {
        if (defined('BLOCKTYPE_JMOL_JS_INCLUDED')) {
            return '';
        }
        define('BLOCKTYPE_JMOL_JS_INCLUDED', true);
        return '<script type="text/javascript" src="'.get_config('wwwroot').'lib/jmol/Jmol.js"></script>
             <script type="text/javascript">jmolInitialize("'.get_config('wwwroot').'lib/jmol/")</script>';
    }

    public static function default_copy_type() {
        return 'full';
    }
}

?>