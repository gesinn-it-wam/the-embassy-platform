<?php

namespace SFS\Tests;

use TAMExpand;
use Parser;
use ParserOptions;
use ParserOutput;
use Title;

/**
 * @covers   TAMExpand
 * @group   semantic-forms-select
 *
 * @license GNU GPL v2+
 * @since   1.3
 *
 * @author  mwjames
 */
class TAMExpandTest extends \PHPUnit_Framework_TestCase {
	private $args = [];
	private $parser;
	private $args2 = [];

	private $testdata_tree1 = '{{#tree:}}';
	private $testdata_tree1_expected = '<div class="fancytree todo"><p>{{#tree:}}
</p></div><script type="text/javascript">if(\'prepareTAM\' in window) window.prepareTAM();</script>';

	private $testdata_tree2 = '{{#tree:*OneBullet}}';
	private $testdata_tree2_expected = '<div class="fancytree todo"><p>{{#tree:*OneBullet}}
</p></div><script type="text/javascript">if(\'prepareTAM\' in window) window.prepareTAM();</script>';

	private $testdata_tree3 = '{{#tree:<div>*OneBullet</div>}}';
	private $testdata_tree3_expected = '<div class="fancytree todo"><p>{{#tree:*OneBullet}}
</p></div><script type="text/javascript">if(\'prepareTAM\' in window) window.prepareTAM();</script>';

	private $testdata_tree4 = '{{#tree:class=navtree}}';
	private $testdata_tree4_expected = '<div class="fancytree todo"><p>{{#tree:class=navtree}}
</p></div><script type="text/javascript">if(\'prepareTAM\' in window) window.prepareTAM();</script>';

	private $testdata_menu1 = '{{#menu:}}';
	private $testdata_menu1_expected = '<p><script type="text/javascript">if(\'prepareTAM\' in window) window.prepareTAM();</script>
</p><script type="text/javascript">if(\'prepareTAM\' in window) window.prepareTAM();</script>';

	private $testdata_menu2 = '{{#menu:*OneBullet}}';
	private $testdata_menu2_expected = '<ul class="suckerfish todo"><li>OneBullet</li></ul>
<p><script type="text/javascript">if(\'prepareTAM\' in window) window.prepareTAM();</script>
</p><script type="text/javascript">if(\'prepareTAM\' in window) window.prepareTAM();</script>';

	protected function setUp() {
		parent::setUp();
		$parser = new Parser( $GLOBALS['wgParserConf'] );
		$parser->setTitle( Title::newFromText( 'Category:Team' ) );
		$parser->mOptions = new ParserOptions();
		$parser->firstCallInit();
		$parser->clearState();
		$this->parser = $parser;
	}

	protected function tearDown() {
		unset( $this->SelectField );
		parent::tearDown();
	}

	public function testCanConstruct() {
		$this->assertInstanceOf( '\TAMExpand', new TAMExpand() );
	}

	// Tree tests

	public function testExpandTree_returns_array() {
		$ret = TAMExpand::expandTree( $this->parser, $this->testdata_tree1 );
		$this->assertInternalType( 'array', $ret );
	}

	public function testExpandTree_empty() {
		$ret = TAMExpand::expandTree( $this->parser, $this->testdata_tree1 );
		$this->assertSame( $ret[0], $this->testdata_tree1_expected );
	}

	public function testExpandTree_one_bullet() {
		$ret = TAMExpand::expandTree( $this->parser, $this->testdata_tree2 );
		#print_r($ret[0]);
		$this->assertSame( $ret[0], $this->testdata_tree2_expected );
	}

	public function testExpandTree_remove_div_container() {
		$ret = TAMExpand::expandTree( $this->parser, $this->testdata_tree3 );
		$this->assertSame( $ret[0], $this->testdata_tree3_expected );
	}

	public function testExpandTree_parameter_class() {
		$ret = TAMExpand::expandTree( $this->parser, $this->testdata_tree4 );
		$this->assertSame( $ret[0], $this->testdata_tree4_expected );
	}

	// Menu tests

	public function testExpandMenu_returns_array() {
		$ret = TAMExpand::expandMenu( $this->parser, $this->testdata_menu1 );
		$this->assertInternalType( 'array', $ret );
	}

	public function testExpandMenu_empty() {
		$ret = TAMExpand::expandMenu( $this->parser, $this->testdata_menu1 );
		$this->assertSame( $ret[0], $this->testdata_menu1_expected );
	}

	public function testExpandMenu_one_bullet() {
		$ret = TAMExpand::expandMenu( $this->parser, $this->testdata_menu2 );
		# print_r($ret[0]);
		$this->assertSame( $ret[0], $this->testdata_menu2_expected );
	}

}
