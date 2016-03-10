<?php
/**
 * ページング処理を行うためのextension
 *
 *
 * シンプルなページング処理を行います。
 *
 *
 *
 *
 * インストール・設定
 * --------------------------------------------------
 * envi install-extension {app_key} {DI設定ファイル} simple_pager
 *
 * コマンドでインストール出来ます。
 *
 *
 * PHP versions 5
 *
 *
 * @category   EnviMVC拡張
 * @package    EnviPHPが用意するエクステンション
 * @subpackage CebeMarkdownExtension
 * @author     Akito <akito-artisan@five-foxes.com>
 * @copyright  2011-2013 Artisan Project
 * @license    http://opensource.org/licenses/BSD-2-Clause The BSD 2-Clause License
 * @version    GIT: $Id$
 * @link       https://github.com/EnviMVC/EnviMVC3PHP
 * @see        https://github.com/EnviMVC/EnviMVC3PHP/wiki
 * @since      File available since Release 1.0.0
*/




/**
 * ページング処理を行うためのextension
 *
 * @category   EnviMVC拡張
 * @package    EnviPHPが用意するエクステンション
 * @subpackage CebeMarkdownExtension
 * @author     Akito <akito-artisan@five-foxes.com>
 * @copyright  2011-2013 Artisan Project
 * @license    http://opensource.org/licenses/BSD-2-Clause The BSD 2-Clause License
 * @version    Release: @package_version@
 * @link       https://github.com/EnviMVC/EnviMVC3PHP
 * @see        https://github.com/EnviMVC/EnviMVC3PHP/wiki
 * @since      Class available since Release 1.0.0
 */


class EnviSimplePagerExtension
{
    protected $system_conf;

    protected $start, $total, $limit, $pager, $request, $last, $offset;

    /**
     * +-- コンストラクタ
     *
     * @access      public
     * @param       string $file_path OPTIONAL:null
     * @return      void
     */
    public function __construct($system_conf)
    {
        $this->system_conf = $system_conf;
    }
    /* ----------------------------------------- */


     /**
     * +-- 初期化
     *
     * @access      public
     * @param       var_text $total
     * @param       var_text $limit OPTIONAL:NULL
     * @param       var_text $pager OPTIONAL:NULL
     * @return      void
     */
    public function initialize($total, $limit = NULL, $pager = NULL)
    {
        $this->start   = $this->getStart();
        $this->total = $total;
        $this->limit = $limit ? $limit : $this->system_conf['default_limit'];
        $this->pager = $pager ? $pager : $this->system_conf['default_pager'];
        $this->request = $this->getRequestPath();
        $this->last = (int)ceil($this->total/$this->limit);
        if ($this->last < $this->start) {
            $this->start = (int)$this->last;
        }
        $this->offset = ($this->start - 1) * $this->limit;
    }
    /* ----------------------------------------- */

    /**
     * +-- Limit取得
     *
     * @access      public
     * @return      int
     * @codeCoverageIgnore
     */
    public function getLimit()
    {
        return (int)$this->limit;
    }
    /* ----------------------------------------- */


    /**
     * +-- Offset取得
     *
     * @access      public
     * @return      int
     * @codeCoverageIgnore
     */
    public function getOffset()
    {
        return (int)$this->offset;
    }
    /* ----------------------------------------- */


    /**
     * +-- 最終ページ取得
     *
     * @access      public
     * @return      int
     * @codeCoverageIgnore
     */
    public function getLastPage()
    {
        return (int)$this->last;
    }
    /* ----------------------------------------- */


    /**
     * +-- 開始位置の取得
     *
     * @access      public
     * @static
     * @return      int
     */
    public function getStart()
    {
        return max((int)$this->getParameter($this->system_conf['start_key'], 1), 1);
    }
    /* ----------------------------------------- */


    /**
     * +-- ページ配列を取得
     *
     * @access      public
     * @return      array
     */
    public function getPages()
    {
        if ($this->last < $this->pager) {
            // pager最大値がlastより小さい場合
            return $this->range(1, min($this->pager, $this->last));
        } elseif ($this->last - $this->pager < $this->start) {
            // 終端処理
            $start = $this->last - $this->pager;
            return $this->range($start, $this->last);
        }
        $pager_diff = (int)ceil($this->pager / 2);
        if ($pager_diff >= $this->start) {
            return $this->range(1, $this->pager);
        }

        $start = $this->start - $pager_diff + 1;
        return $this->range($start, $start + $this->pager - 1);
    }
    /* ----------------------------------------- */

    /**
     * +-- URL配列の取得
     *
     * @access      public
     * @return      array
     */
    public function getUrls()
    {
        $pages        = $this->getPages();
        $query_string = $this->getQueryString();
        $base_url     = $this->getRequestPath().'?'.$query_string;
        $amp          = '';

        if (mb_strlen($query_string)) {
            $amp = '&';
        }
        $base_url .= $amp.$this->system_conf['start_key'].'=';

        $res = array();
        foreach ($pages as $page) {
            $res[$page] = $base_url.$page;
        }
        return $res;
    }
    /* ----------------------------------------- */



    /**
     * +-- クエリストリングの取得
     *
     * @access      public
     * @return      string
     */
    public function getQueryString()
    {
        $query_string = '';

        $str_key = preg_quote($this->system_conf['start_key']);
        if (isset($_SERVER['QUERY_STRING'])) {
            $query_string = mb_ereg_replace('(&'.$str_key.'=[^&]+|^'.$str_key.'=[^&]+&?)', '', $_SERVER['QUERY_STRING']);
        }
        return $query_string;
    }
    /* ----------------------------------------- */

   /**
     * +-- QueryStringを除いたパスを取得する
     *
     * @access      public
     * @return      string
     */
   public function getRequestPath()
   {
       $res = $_SERVER['SCRIPT_NAME'];
       if (isset($_SERVER['PATH_INFO'])) {
           $res .= $_SERVER['PATH_INFO'];
       }
       return $res;
   }
   /* ----------------------------------------- */

    /** +-- エイリアス */
    /**
     * +-- EnviRequest::getParameterへのエイリアス
     *
     * @access      public
     * @param       string $key
     * @param       string|bool $default_value
     * @return      string
     * @codeCoverageIgnore
     */
    public function getParameter($key, $default_value)
    {
        return EnviRequest::getParameter($key, $default_value);
    }
   /* ----------------------------------------- */

    /**
     * +-- range 関数へのエイリアス
     *
     * @access      public
     * @param       var_text $start
     * @param       var_text $end
     * @return      array
     * @codeCoverageIgnore
     */
    public function range($start, $end)
    {
        return range($start, $end);
    }
    /* ----------------------------------------- */
    /* ----------------------------------------- */


}
