<?php
/**
 *
 *
 *
 * PHP versions 5
 *
 *
 *
 * @category   %%project_category%%
 * @package    %%project_name%%
 * @subpackage %%subpackage_name%%
 * @author     %%your_name%% <%%your_email%%>
 * @copyright  %%your_project%%
 * @license    %%your_license%%
 * @version    GIT: $Id$
 * @link       %%your_link%%
 * @see        http://www.enviphp.net/c/man/v3/core/unittest
 * @since      File available since Release 1.0.0
 * @doc_ignore
 */

/**
 *
 *
 *
 *
 * @category   %%project_category%%
 * @package    %%project_name%%
 * @subpackage %%subpackage_name%%
 * @author     %%your_name%% <%%your_email%%>
 * @copyright  %%your_project%%
 * @license    %%your_license%%
 * @version    GIT: $Id$
 * @link       %%your_link%%
 * @see        http://www.enviphp.net/c/man/v3/core/unittest
 * @since      File available since Release 1.0.0
 * @doc_ignore
 */
class EnviSimplePagerTest extends testCaseBase
{

    protected $EnviSimplePagerExtension;

    /**
     * +-- 初期化
     *
     * @access public
     * @return void
     */
    public function initialize()
    {
        $this->free();
        $this->EnviSimplePagerExtension = new EnviSimplePagerExtension([
            'start_key' => 'sample_start',
            'default_limit'     => 10,
            'default_pager'      => 10,
            'default_pager_span' => 20,
            ]);
    }
    /* ----------------------------------------- */

    /**
     * +-- レンジのテスト
     *
     * @access      public
     * @return      void
     * @test
     */
    public function rangePager10PagerSpan10Max50Test()
    {
        $EnviSimplePagerExtension = EnviMockLight::mock('EnviSimplePagerExtension', [[
            'start_key' => 'sample_start',
            'default_limit'     => 10,
            'default_pager'      => 10,
            'default_pager_span' => 10,
            ]], false);


        $EnviSimplePagerExtension->shouldReceive('getRequestPath')
        ->once()
        ->andReturn('/aaaa/bbbb/');


        // 開始位置が1で、件数default_limit*default_pager未満の時
        $EnviSimplePagerExtension->shouldReceive('getParameter')
        ->with('sample_start', 1)
        ->once()
        // 開始位置 1
        ->andReturn(1);
        $EnviSimplePagerExtension->shouldReceive('range')
        ->once()
        ->with(1, 5)
        ->andNoBypass();

        $EnviSimplePagerExtension->initialize(50);
        $res = $EnviSimplePagerExtension->getPages();

        $this->assertCount(5, $res);


        EnviMockLight::getMockEditor($EnviSimplePagerExtension)->recycle('getRequestPath');
        $EnviSimplePagerExtension->shouldReceive('getParameter')
        ->with('sample_start', 1)
        ->once()
        // 開始位置 2
        ->andReturn(2);
        $EnviSimplePagerExtension->shouldReceive('range')
        ->once()
        ->with(1, 5)
        ->andNoBypass();

        $EnviSimplePagerExtension->initialize(50);
        $EnviSimplePagerExtension->getPages();

        $this->assertCount(5, $res);


        EnviMockLight::getMockEditor($EnviSimplePagerExtension)->recycle('getRequestPath');
        $EnviSimplePagerExtension->shouldReceive('getParameter')
        ->with('sample_start', 1)
        ->once()
        // 開始位置 5(終端)
        ->andReturn(5);
        $EnviSimplePagerExtension->shouldReceive('range')
        ->once()
        ->with(1, 5)
        ->andNoBypass();
        $EnviSimplePagerExtension->initialize(50);
        $EnviSimplePagerExtension->getPages();

        $this->assertCount(5, $res);


        EnviMockLight::getMockEditor($EnviSimplePagerExtension)->recycle('getRequestPath');
        $EnviSimplePagerExtension->shouldReceive('getParameter')
        ->with('sample_start', 1)
        ->once()
        // 開始位置 6(オーバー)
        ->andReturn(6);
        $EnviSimplePagerExtension->shouldReceive('range')
        ->once()
        ->with(1, 5)
        ->andNoBypass();
        $EnviSimplePagerExtension->initialize(50);
        $EnviSimplePagerExtension->getPages();

        $this->assertCount(5, $res);

    }
    /* ----------------------------------------- */



    /**
     * +-- レンジのテスト
     *
     * @access      public
     * @return      void
     * @test
     */
    public function rangePager10PagerSpan10Max1000Test()
    {
        $EnviSimplePagerExtension = EnviMockLight::mock('EnviSimplePagerExtension', [[
            'start_key' => 'sample_start',
            'default_limit'     => 10,
            'default_pager'      => 10,
            'default_pager_span' => 10,
            ]], false);


        $EnviSimplePagerExtension->shouldReceive('getRequestPath')
        ->once()
        ->andReturn('/aaaa/bbbb/');


        // 開始位置が1で、件数default_limit*default_pager未満の時
        $EnviSimplePagerExtension->shouldReceive('getParameter')
        ->with('sample_start', 1)
        ->once()
        // 開始位置 1
        ->andReturn(1);
        $EnviSimplePagerExtension->shouldReceive('range')
        ->once()
        ->with(1, 10)
        ->andNoBypass();

        $EnviSimplePagerExtension->initialize(1000);
        $res = $EnviSimplePagerExtension->getPages();


        $this->assertEquals(100, $EnviSimplePagerExtension->getLastPage());
        $this->assertCount(10, $res);
        $this->assertEquals(range(1, 10), $res);




        EnviMockLight::getMockEditor($EnviSimplePagerExtension)->recycle('getRequestPath');
        $EnviSimplePagerExtension->shouldReceive('getParameter')
        ->with('sample_start', 1)
        ->once()
        // 開始位置 2
        ->andReturn(2);
        $EnviSimplePagerExtension->shouldReceive('range')
        ->once()
        ->with(1, 10)
        ->andNoBypass();

        $EnviSimplePagerExtension->initialize(1000);
        $EnviSimplePagerExtension->getPages();

        $this->assertEquals(100, $EnviSimplePagerExtension->getLastPage());
        $this->assertCount(10, $res);


        EnviMockLight::getMockEditor($EnviSimplePagerExtension)->recycle('getRequestPath');
        $EnviSimplePagerExtension->shouldReceive('getParameter')
        ->with('sample_start', 1)
        ->once()
        // 開始位置 3
        ->andReturn(3);
        $EnviSimplePagerExtension->shouldReceive('range')
        ->once()
        ->with(1, 10)
        ->andNoBypass();

        $EnviSimplePagerExtension->initialize(1000);
        $EnviSimplePagerExtension->getPages();

        $this->assertEquals(100, $EnviSimplePagerExtension->getLastPage());
        $this->assertCount(10, $res);

        EnviMockLight::getMockEditor($EnviSimplePagerExtension)->recycle('getRequestPath');
        $EnviSimplePagerExtension->shouldReceive('getParameter')
        ->with('sample_start', 1)
        ->once()
        // 開始位置 4
        ->andReturn(4);

        $EnviSimplePagerExtension->shouldReceive('range')
        ->once()
        ->with(1, 10)
        ->andNoBypass();

        $EnviSimplePagerExtension->initialize(1000);
        $EnviSimplePagerExtension->getPages();

        $this->assertEquals(100, $EnviSimplePagerExtension->getLastPage());
        $this->assertCount(10, $res);


        EnviMockLight::getMockEditor($EnviSimplePagerExtension)->recycle('getRequestPath');
        $EnviSimplePagerExtension->shouldReceive('getParameter')
        ->with('sample_start', 1)
        ->once()
        // 開始位置 5
        ->andReturn(5);
        $EnviSimplePagerExtension->shouldReceive('range')
        ->once()
        ->with(1, 10)
        ->andNoBypass();

        $EnviSimplePagerExtension->initialize(1000);
        $EnviSimplePagerExtension->getPages();

        $this->assertEquals(100, $EnviSimplePagerExtension->getLastPage());
        $this->assertCount(10, $res);


        EnviMockLight::getMockEditor($EnviSimplePagerExtension)->recycle('getRequestPath');
        $EnviSimplePagerExtension->shouldReceive('getParameter')
        ->with('sample_start', 1)
        ->once()
        // 開始位置 6
        ->andReturn(6);
        $EnviSimplePagerExtension->shouldReceive('range')
        ->once()
        ->with(2, 11)
        ->andNoBypass();

        $EnviSimplePagerExtension->initialize(1000);
        $EnviSimplePagerExtension->getPages();

        $this->assertEquals(100, $EnviSimplePagerExtension->getLastPage());
        $this->assertCount(10, $res);




        EnviMockLight::getMockEditor($EnviSimplePagerExtension)->recycle('getRequestPath');
        $EnviSimplePagerExtension->shouldReceive('getParameter')
        ->with('sample_start', 1)
        ->once()
        // 開始位置 10
        ->andReturn(10);
        $EnviSimplePagerExtension->shouldReceive('range')
        ->once()
        ->with(6, 15)
        ->andNoBypass();

        $EnviSimplePagerExtension->initialize(1000);
        $EnviSimplePagerExtension->getPages();

        $this->assertEquals(100, $EnviSimplePagerExtension->getLastPage());
        $this->assertCount(10, $res);


        EnviMockLight::getMockEditor($EnviSimplePagerExtension)->recycle('getRequestPath');
        $EnviSimplePagerExtension->shouldReceive('getParameter')
        ->with('sample_start', 1)
        ->once()
        // 開始位置 95
        ->andReturn(95);
        $EnviSimplePagerExtension->shouldReceive('range')
        ->once()
        ->with(90, 100)
        ->andNoBypass();

        $EnviSimplePagerExtension->initialize(1000);
        $EnviSimplePagerExtension->getPages();

        $this->assertEquals(100, $EnviSimplePagerExtension->getLastPage());
        $this->assertCount(10, $res);



        EnviMockLight::getMockEditor($EnviSimplePagerExtension)->recycle('getRequestPath');
        $EnviSimplePagerExtension->shouldReceive('getParameter')
        ->with('sample_start', 1)
        ->once()
        // 開始位置 100(終端)
        ->andReturn(100);
        $EnviSimplePagerExtension->shouldReceive('range')
        ->once()
        ->with(90, 100)
        ->andNoBypass();
        $EnviSimplePagerExtension->initialize(1000);
        $EnviSimplePagerExtension->getPages();

        $this->assertEquals(100, $EnviSimplePagerExtension->getLastPage());
        $this->assertCount(10, $res);


        EnviMockLight::getMockEditor($EnviSimplePagerExtension)->recycle('getRequestPath');
        $EnviSimplePagerExtension->shouldReceive('getParameter')
        ->with('sample_start', 1)
        ->once()
        // 開始位置 101(オーバー)
        ->andReturn(101);
        $EnviSimplePagerExtension->shouldReceive('range')
        ->once()
        ->with(90, 100)
        ->andNoBypass();
        $EnviSimplePagerExtension->initialize(1000);
        $EnviSimplePagerExtension->getPages();

        $this->assertEquals(100, $EnviSimplePagerExtension->getLastPage());
        $this->assertCount(10, $res);

    }
    /* ----------------------------------------- */


    /**
     * +-- レンジのテスト
     *
     * @access      public
     * @return      void
     * @test
     */
    public function getUrlsTest()
    {
        $EnviSimplePagerExtension = EnviMockLight::mock('EnviSimplePagerExtension', [[
            'start_key' => 'sample_start',
            'default_limit'     => 10,
            'default_pager'      => 10,
            'default_pager_span' => 10,
            ]], false);
        $EnviSimplePagerExtension->shouldReceive('getPages')
        ->once()
        ->andReturn(range(5, 10));

        $EnviSimplePagerExtension->shouldReceive('getQueryString')
        ->once()
        ->with()
        ->andReturn('');
        $EnviSimplePagerExtension->shouldReceive('getRequestPath')
        ->once()
        ->with()
        ->andReturn('/test/tests');

        $res = $EnviSimplePagerExtension->getUrls();
        $this->assertEquals($res, array (
              5 => '/test/tests?sample_start=5',
              6 => '/test/tests?sample_start=6',
              7 => '/test/tests?sample_start=7',
              8 => '/test/tests?sample_start=8',
              9 => '/test/tests?sample_start=9',
              10 => '/test/tests?sample_start=10',
            )
        );

        $EnviSimplePagerExtension->shouldReceive('getPages')
        ->once()
        ->andReturn(range(5, 10));

        $EnviSimplePagerExtension->shouldReceive('getQueryString')
        ->once()
        ->with()
        ->andReturn('aaaa=bbbb');
        $EnviSimplePagerExtension->shouldReceive('getRequestPath')
        ->once()
        ->with()
        ->andReturn('/tests/test');
        $res = $EnviSimplePagerExtension->getUrls();
        $this->assertEquals($res, array (
              5 => '/tests/test?aaaa=bbbb&sample_start=5',
              6 => '/tests/test?aaaa=bbbb&sample_start=6',
              7 => '/tests/test?aaaa=bbbb&sample_start=7',
              8 => '/tests/test?aaaa=bbbb&sample_start=8',
              9 => '/tests/test?aaaa=bbbb&sample_start=9',
              10 => '/tests/test?aaaa=bbbb&sample_start=10',
            )
        );
    }


    /**
     * +-- クエリストリングが無いとき
     *
     * @access      public
     * @return      void
     * @test
     */
    public function getQueryStringNoQueryStringTest()
    {
        unset($_SERVER['QUERY_STRING']);
        $this->assertEmpty($this->EnviSimplePagerExtension->getQueryString());
    }
    /* ----------------------------------------- */

    /**
     * +-- クエリストリングがあるけどStart位置がないとき
     *
     * @access      public
     * @return      void
     * @test
     */
    public function getQueryStringDisableStrTest()
    {
        $_SERVER['QUERY_STRING'] = 'aaaa=bbbb&cccc=cccc&dddd=dddd';
        $this->assertEquals($this->EnviSimplePagerExtension->getQueryString(), $_SERVER['QUERY_STRING']);
        $_SERVER['QUERY_STRING'] = 'aaaa=bbbb&cccc=cccc&dddd=dddd&sample_start_=12';
        $this->assertEquals($this->EnviSimplePagerExtension->getQueryString(), $_SERVER['QUERY_STRING']);
        $_SERVER['QUERY_STRING'] = 'aaaa=bbbb&cccc=cccc&dddd=dddd&_sample_start=12';
        $this->assertEquals($this->EnviSimplePagerExtension->getQueryString(), $_SERVER['QUERY_STRING']);
        $_SERVER['QUERY_STRING'] = 'aaaa=bbbb&cccc=cccc&dddd=dddd&start_key=12';
        $this->assertEquals($this->EnviSimplePagerExtension->getQueryString(), $_SERVER['QUERY_STRING']);
    }
    /* ----------------------------------------- */

    /**
     * +-- クエリストリングがあるけどStart位置がないとき
     *
     * @access      public
     * @return      void
     * @test
     */
    public function getQueryStringEnableStrTest()
    {
        // 先頭
        $_SERVER['QUERY_STRING'] = 'sample_start=1&aaaa=bbbb&cccc=cccc&dddd=dddd';
        $this->assertEquals($this->EnviSimplePagerExtension->getQueryString(), 'aaaa=bbbb&cccc=cccc&dddd=dddd');

        $_SERVER['QUERY_STRING'] = 'sample_start=1123546&aaaa=bbbb&cccc=cccc&dddd=dddd';
        $this->assertEquals($this->EnviSimplePagerExtension->getQueryString(), 'aaaa=bbbb&cccc=cccc&dddd=dddd');

        // 終端
        $_SERVER['QUERY_STRING'] = 'aaaa=bbbb&cccc=cccc&dddd=dddd&sample_start=1';
        $this->assertEquals($this->EnviSimplePagerExtension->getQueryString(), 'aaaa=bbbb&cccc=cccc&dddd=dddd');
        $_SERVER['QUERY_STRING'] = 'aaaa=bbbb&cccc=cccc&dddd=dddd&sample_start=1123456';
        $this->assertEquals($this->EnviSimplePagerExtension->getQueryString(), 'aaaa=bbbb&cccc=cccc&dddd=dddd');

        // 真ん中
        $_SERVER['QUERY_STRING'] = 'aaaa=bbbb&cccc=cccc&sample_start=1&dddd=dddd';
        $this->assertEquals($this->EnviSimplePagerExtension->getQueryString(), 'aaaa=bbbb&cccc=cccc&dddd=dddd');
        $_SERVER['QUERY_STRING'] = 'aaaa=bbbb&cccc=cccc&sample_start=123456789&dddd=dddd';
        $this->assertEquals($this->EnviSimplePagerExtension->getQueryString(), 'aaaa=bbbb&cccc=cccc&dddd=dddd');


        // シンプルにこれだけなら削除
        $_SERVER['QUERY_STRING'] = 'sample_start=11234';
        $this->assertEmpty($this->EnviSimplePagerExtension->getQueryString());


    }
    /* ----------------------------------------- */

    /**
     * +-- getRequestPathのテスト
     *
     * @access      public
     * @return      void
     * @test
     */
    public function getRequestPathTest()
    {
        // 先頭
        $_SERVER['SCRIPT_URL'] = '/aaa.php/module/action/example';
        $_SERVER['PATH_INFO'] = '/module/action/example';
        $this->assertEquals($this->EnviSimplePagerExtension->getRequestPath(), $_SERVER['SCRIPT_URL']);

        unset($_SERVER['PATH_INFO']);
        $this->assertEquals($this->EnviSimplePagerExtension->getRequestPath(), $_SERVER['SCRIPT_URL']);

    }
    /* ----------------------------------------- */



    /**
     * +-- 終了処理
     *
     * @access public
     * @return void
     */
    public function shutdown()
    {
    }

}
