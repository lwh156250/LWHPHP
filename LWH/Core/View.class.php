<?php
namespace Core;

class View{
	 /**
     * 模板输出变量
     * @var tVar
     * @access protected
     */ 
    protected $tVar     =   array();

    /**
    * layout 模块
    * add by lwh 2015-11-30
    */
    protected $layoutFile   =   null;

    /**
     * 模板主题
     * @var theme
     * @access protected
     */ 
    protected $theme    =   '';

    /**
     * 模板变量赋值
     * @access public
     * @param mixed $name
     * @param mixed $value
     */
    public function assign($name,$value=''){
        if(is_array($name)) {
            $this->tVar   =  array_merge($this->tVar,$name);
        }else {
            $this->tVar[$name] = $value;
        }
    }

    /**
     * 取得模板变量的值
     * @access public
     * @param string $name
     * @return mixed
     */
    public function get($name=''){
        if('' === $name) {
            return $this->tVar;
        }
        return isset($this->tVar[$name])?$this->tVar[$name]:false;
    }

    /**
     * 加载模板和页面输出 可以返回输出内容
     * @access public
     * @param string $templateFile 模板文件名
     * @param string $charset 模板输出字符集
     * @param string $contentType 输出类型
     * @param string $content 模板输出内容
     * @param string $prefix 模板缓存前缀
     * @return mixed
     */
    public function display($templateFile='',$charset='',$contentType='',$content='',$prefix='') {
        // G('viewStartTime');
        // 视图开始标签
        Hook::listen('view_begin',$templateFile);
        // 解析并获取模板内容
        $content = $this->fetch($templateFile,$content,$prefix);
        // 输出模板内容
        $this->render($content,$charset,$contentType);
        // 视图结束标签
        Hook::listen('view_end');
    }

    /**
     * 输出内容文本可以包括Html
     * @access private
     * @param string $content 输出内容
     * @param string $charset 模板输出字符集
     * @param string $contentType 输出类型
     * @return mixed
     */
    private function render($content,$charset='',$contentType=''){
        if(empty($charset))  $charset = C('DEFAULT_CHARSET');
        if(empty($contentType)) $contentType = C('TMPL_CONTENT_TYPE');
        // 网页字符编码
        header('Content-Type:'.$contentType.'; charset='.$charset);
        header('Cache-control: '.C('HTTP_CACHE_CONTROL'));  // 页面缓存控制
        extract($this->tVar, EXTR_OVERWRITE);
        // 输出模板文件
        \Core\Storage::load($content, $this->tVar);
        // echo $content;
    }

    /**
     * 解析和获取模板内容 用于输出
     * @access public
     * @param string $templateFile 模板文件名
     * @param string $content 模板输出内容
     * @param string $prefix 模板缓存前缀
     * @return string
     */
    public function fetch($templateFile='',$content='',$prefix='') {
        if(empty($content)) {
            $layoutFile     =   $this->parseLayout();
            $templateFile   =   $this->parseTemplate($templateFile);
            // 模板文件不存在直接返回
            if(!is_file($templateFile)) die("$templateFile is not existent");
            $tmplContent = file_get_contents($templateFile);

            //开启layout
            if($layoutFile){                
                if(false !== strpos($tmplContent,'{__NOLAYOUT__}')) { // 可以单独定义不使用布局
                    $tmplContent = str_replace('{__NOLAYOUT__}','',$tmplContent);
                }else{ // 替换布局的主体内容
                    $tmplContent = str_replace('{__CONTENT__}',$tmplContent,file_get_contents($layoutFile));
                }
            }
        }else{
            $templateFile = $tmplContent = $content;
        }
        // 内容过滤标签      
        Hook::listen('view_filter',$tmplContent);

        //缓存
        $cacheFile = APP_PATH . 'Runtime/'. CONTROLLER_NAME . '/' . ACTION_NAME . '-' . md5($templateFile . $layoutFile) . C('RUNTIME_SUFFIX');
        if((!empty($content) && Storage::has($cacheFile)) || $this->checkCache($cacheFile,$templateFile,$layoutFile)){
            // echo '已经有缓存了！';
        }else{      
            // echo '进行缓存了！';
            \Core\Storage::put($cacheFile, $tmplContent);
        }
        return $cacheFile;
    }

    /**
     * 自动定位模板文件
     * @access protected
     * @param string $template 模板文件规则
     * @return string
     */
    public function parseTemplate($template='') {
        if(is_file($template)) {
            return $template;
        }
        $depr       =   C('DEFAULT_DEPR');
        // 分析模板文件规则
        if('' == $template) {
            // 如果模板文件名为空 按照默认规则定位
            $template = CONTROLLER_NAME . $depr . ACTION_NAME . C('TMPL_TEMPLATE_SUFFIX');        
        }else{
            $template = $template . C('TMPL_TEMPLATE_SUFFIX');
        }
        $file   =   APP_PATH. 'View/' . $template;
        return $file;
    }

    /**
     * 设置当前输出的模板主题
     * @access public
     * @param  mixed $theme 主题名称
     * @return View
     */
    public function theme($theme){
        $this->theme = $theme;
        return $this;
    }

    /**
     * 获取当前的模板主题
     * @access private
     * @return string
     */
    private function getTemplateTheme() {
        if($this->theme) { // 指定模板主题
            $theme = $this->theme;
        }else{
            /* 获取模板主题名称 */
            $theme =  C('DEFAULT_THEME');
            if(C('TMPL_DETECT_THEME')) {// 自动侦测模板主题
                $t = C('VAR_TEMPLATE');
                if (isset($_GET[$t])){
                    $theme = $_GET[$t];
                }elseif(cookie('think_template')){
                    $theme = cookie('think_template');
                }
                if(!in_array($theme,explode(',',C('THEME_LIST')))){
                    $theme =  C('DEFAULT_THEME');
                }
                cookie('think_template',$theme,864000);
            }
        }
        defined('THEME_NAME') || define('THEME_NAME',   $theme);                  // 当前模板主题名称
        return $theme?$theme . '/':'';
    }

    public function layout($layoutFile = null){
        $this->layoutFile = $layoutFile;
        return $this;
    }

    public function parseLayout(){
        if(!C('LAYOUT_ON') && is_null($this->layoutFile)){
            return false;
        }

        $layoutFile     =   is_null($this->layoutFile) ? C('DEFAULT_LAYOUT') : $this->layoutFile;

        $depr           =   C('DEFAULT_DEPR');       

        if(is_file($layoutFile)) {
            return $layoutFile;
        }
        // 分析layout文件规则
        if(is_null($layoutFile)){
            return false;
        }

        if('' == $layoutFile) {
            // 如果模板文件名为空 按照默认规则定位
            $layoutFile = CONTROLLER_NAME . $depr . ACTION_NAME . C('TMPL_TEMPLATE_SUFFIX');        
        }else{
            $layoutFile = $layoutFile . C('TMPL_TEMPLATE_SUFFIX');
        }
        $file   =   APP_PATH. 'View/Layout/' . $layoutFile;
        is_file($file) or die("Layout file $file is not existent!");
        return $file;
    }

    protected function checkCache($cacheFile, $templateFile, $layoutFile) {
        if(!Storage::has($cacheFile)){
            return false;
        }elseif (filemtime($templateFile) > filemtime($cacheFile)) {
            // 模板文件如果有更新则缓存需要更新
            return false;
        }
        //elseif(){}//缓存时间判断
        // 开启布局模板
        if($layoutFile) {
            if(filemtime($layoutFile) > filemtime($cacheFile)) {
                return false;
            }
        }
        // 缓存有效
        return true;
    }

}