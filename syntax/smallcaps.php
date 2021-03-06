<?php
/**
 * DokuWiki Plugin Typography; Syntax typography smallcaps
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Satoshi Sahara <sahara.satoshi@gmail.com>
 *
 */

require_once(dirname(__FILE__).'/base.php');

class syntax_plugin_typography_smallcaps extends syntax_plugin_typography_base {

    protected $pattern = array(
        1 => '<smallcaps\b.*?>(?=.*?</smallcaps>)',
        4 => '</smallcaps>',
    );

    //protected $styler = null;

    /*
     * Handle the match
     */
    function handle($match, $state, $pos, Doku_Handler $handler) {
        switch($state) {
            case DOKU_LEXER_ENTER:
                // load prameter parser utility
                if (is_null($this->styler)) {
                    $this->styler = $this->loadHelper('typography_parser');
                }

                // get inline CSS parameter
                $params = 'fv:small-caps;'.strtolower(ltrim(substr($match, 10, -1)));

                // get css property:value pairs as an associative array
                $tag_data = $this->styler->parse_inlineCSS($params);

                return array($state, $tag_data);

            case DOKU_LEXER_UNMATCHED:
                $handler->_addCall('cdata', array($match), $pos);
                return false;

            case DOKU_LEXER_EXIT:
                return array($state, '');
        }
        return array();
    }

}
