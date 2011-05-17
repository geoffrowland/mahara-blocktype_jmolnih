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

$string['title'] = 'Jmol NIH';
$string['description'] = 'Embed Jmol 3D chemical structures from the NIH NCI/CADD Chemical Identifier Resolver service';
$string['jmolnihsearch'] = 'Search term';
$string['jmolnihsearchdescription2'] = 'Enter the search term.';
$string['jmolnihsearchpatterns'] = 'May be <a target="blank" href="http://cactus.nci.nih.gov/chemical/structure/documentation">Chemical name</a> (trivial name, systematic name, synonym), IUPAC name, <a target="blank" title="SMILES reference" href="http://www.daylight.com/dayhtml/doc/theory/theory.smiles.html">SMILES</a>, <a target="blank" href="http://www.iupac.org/inchi/release102final.html">InChI</a> or <a target="blank" href="http://www.iupac.org/inchi/release102final.html">Standard InChIKey</a> format.
<br />NB Some search terms may not return correct stereochemistry or tautomerism';
$string['showdescription'] = 'Show Description?';
$string['width'] = 'Width';
$string['height'] = 'Height';
$string['download'] = 'View/download structure file';
$string['invalidurl'] = 'Invalid URL';
$string['jmolscript'] = 'Jmol startup script';
$string['jmolscriptdescription'] = 'Optional <a target="blank" title="Jmol interactive scripting documentation" href="http://chemapps.stolaf.edu/jmol/docs/">Jmol script</a> to be loaded with Jmol applet to customise initial display';
$string['controlscript'] = 'Jmol.js JavaScript';
$string['controlscriptdescription'] = 'Optional <a target="blank" title="Jmol.js JavaScript Library" href="http://jmol.sourceforge.net/jslibrary/">Jmol.js JavaScript</a> to add custom controls below Jmol applet<br />
e.g. <a target="blank" href="http://jmol.sourceforge.net/jslibrary/#jmolButton">jmolButton</a>, <a target="blank" href="http://jmol.sourceforge.net/jslibrary/#jmolLink">jmolLink</a>, <a target="blank" href="http://jmol.sourceforge.net/jslibrary/#jmolCheckbox">jmolCheckbox</a>, <a target="blank" href="http://jmol.sourceforge.net/jslibrary/#jmolRadioGroup">jmolRadioGroup</a>, <a target="blank" href="http://jmol.sourceforge.net/jslibrary/#jmolMenu">jmolMenu</a>, <a target="blank" href="http://jmol.sourceforge.net/jslibrary/#jmolHtml">jmolHtml</a> and <a target="blank" href="http://jmol.sourceforge.net/jslibrary/#jmolBr">jmolBr</a>.';
?>