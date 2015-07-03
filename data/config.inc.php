<?php
	//警告：此文件为自动生成，请不要手动修改此文件
	//数据库配置信息
	define('DB_HOST', 'localhost'); //数据库服务器主机地址
	define('DB_USER', 'root'); //数据库帐号
	define('DB_PSW', 'root'); //数据库密码
	define('DB_NAME', 'zlc'); //数据库名
	define('DB_PRE', 'zlc_'); //数据库表前缀，同一数据库安装多套RTCMS时，请修改表前缀
	define('DB_PCONNECT', 0); //true 或false，是否使用持久连接
	define('DB_CHARSET', 'utf8'); //数据库字符集

	//网站路径配置
	define('RETENG_PATH', '/'); //RTCMS框架访问路径，相对于域名
	//缓存路径
	define('CACHE_STORAGE', 'mysql'); // 缓存存储方式（files, mysql, memcache）
	define('CACHE_TTL', 1900); //Cache 生命周期（秒）（files）
	define('CACHE_PATH', RETENG_ROOT.'data/cache/'); //缓存默认存储路径（files）
	//Session配置
	define('SESSION_STORAGE', 'mysql'); //Session 存储方式（files, mysql, memcache）
	define('SESSION_TTL', 1800); //Session 生命周期（秒）
	define('SESSION_SAVEPATH', RETENG_ROOT.'/data/sessions/'); //Session 保存路径（files）
	//MemCache服务器配置
	define('MEMCACHE_HOST', '127.0.0.1'); //MemCache服务器主机
	define('MEMCACHE_PORT', 11211); //MemCache服务器端口
	define('MEMCACHE_TIMEOUT', 10); //S，MemCache服务器连接超时
	//Cookie配置
	define('COOKIE_DOMAIN', ''); //Cookie 作用域
	define('COOKIE_PATH', '/'); //Cookie 作用路径
	define('COOKIE_PRE', 'OyokPpvmMg'); //Cookie 前缀，同一域名下安装多套Dircms时，请修改Cookie前缀
	define('COOKIE_TTL', 0); //Cookie 生命周期，0 表示随浏览器进程
	define('AUTH_KEY', 'cO0Cp4NdRa'); //网站安全密钥
	//模板相关配置
	define('TPL_ROOT', RETENG_ROOT.'template/'); //模板保存物理路径
	define('TPL_CACHEPATH', RETENG_ROOT.'data/cache_template/'); //模板缓存物理路径
	//模版标记配置
	define('TPL_START', '{'); //模板保存物理路径
	define('TPL_END', '}'); //模板保存物理路径
	//网站基本配置 
	define('SITE_URL', 'http://localhost/'); // 主站访问域名
	define('TIMEDF', '8'); // 默认时区
	define('GZIP', 0); //是否Gzip压缩后输出，Gzip开启以后会将输出到用户浏览器的数据进行压缩的处理，这样就会减小通过网络传输的数据量，提高浏览的速度
	define('PASSWORD_KEY', 'o2aeyMl84e'); //会员密码密钥，为了加强密码强度防止暴力破解，不可更改
	define('SERIAL_NUMBER', ''); // 产品序列号
	define('RETENG_DATA', 'http://cms.reteng.org/'); // 更新服务器
	define('LANG', 'zh-cn'); //默认语言包
	define('ADMIN_FOUNDERS', 1); //网站创始人ID，多个ID逗号分隔
	define('DEBUG',1); //调试配置
	define('CHECKCODE','0');  //开启验证码,默认关闭，开启后登陆后台模板需要支持显示才可。
	//附件相关配置
	define('UPLOAD_FTYPE', 'jpg|png|jpeg|gif|bmp|rar|swf|txt|zip|mp3'); //允许上传的文件类型
	define('UPLOAD_SIZE', 1024000); //允许上传的文件大小
	define('UPLOAD_LIMIT', 10); //允许同时上传的文件个数
	define('WATERMARK_ENABLED', 0); //水印设置
	define('WATERMARK_FILE',RETENG_ROOT.'images/watermark.png'); //水印图片位置
	define('WATERMARK_WORDS', 'http://www.reteng.org/'); //水印文字
	define('WATERMARK_COLOR', '#FF3300'); //水印文字颜色
	define('WATERMARK_POS', 9); //水印位置
	define('WATERMARK_PCT', 60); //水印透明度 0-100
	define('WATERMARK_MINWIDTH', 400); //上传尺寸最小宽度
	define('WATERMARK_MINHEIGHT', 200); //上传尺寸最小高度
	//FTP设置
	define('FTP', '0'); // 是否开启FTP
	define('SSL', '0');
	define('PASV', '1');
	define('FTP_SERVER', '');
	define('FTP_PORT', '21');
	define('FTP_USER', 'admin');
	define('FTP_PWD', 'adminadmin');
	define('FTP_DIR', './');
	define('FTP_URL', '');
	define('FTP_TIMEOUT', '90');
	//邮件相关配置
	define('MAIL_TYPE', '1'); //发送邮件使用的方法
	define('MAIL_SERVER', 'smtp.126.com'); //邮件发送服务器 
	define('MAIL_PORT', '25'); //邮件发送端口，默认：25
	define('MAIL_USER', 'admin'); //发送邮箱帐号
	define('MAIL_PWD', 'adminadmin'); //发送邮箱密码
	define('MAIL_SIGN', ''); //邮件签名
	define('PHONE_USERNAME', ''); //发送邮箱帐号
	define('PHONE_PWD', ''); //发送邮箱密码
	//UC设置
	define('UC', '0'); // 是否开启UC
	define('UC_CONNECT', 'mysql');
	define('UC_DBHOST', 'localhost');
	define('UC_DBUSER', 'admin');
	define('UC_DBPW', '52271915');
	define('UC_DBNAME', 'uc');
	define('UC_DBCHARSET', 'utf8');
	define('UC_DBTABLEPRE', 'uc_');
	define('UC_DBCONNECT', '0');
	define('UC_KEY', 'maD6Ma21A086gdy1e');
	define('UC_API', 'http://localhost/uc');
	define('UC_CHARSET', 'utf8');
	define('UC_IP', '');
	define('UC_APPID', '1');
	define('UC_PPP', '20');
	//性能选项
	define('LOG_DISABLED', 0); // 关闭管理日志
	define('CACHE_COUNT_TTL',10); // 缓存设置 10 
	define('PAGESIZE', 15); // 列表页每页的分页数量
	define('HTMLSIZE', 100); // 发布内容时更新列表页数量
	define('SEARCHTTL', 1000); //搜索缓存时间
	define('AUTOCREATEINDEX', '1'); // 发布文章时更新网站主页
	define('AUTOCREATECATEGORY', '1'); // 发布文章时更新对应栏目
	define('AUTOWYC', '0'); // 发布/编辑内容时启用伪原创
	// 拓展功能
	define('ADMIN_FILE', 'admin.php'); //后台文件名
	define('COMMENTPASS', '1'); // 内容评论是否需要审核
	define('PLUGINS','plugins'); // 插件目录 
	define('TITLECHECK', '0'); // 启用标题检测
	define('MAPAPI', 'baiduditu'); // 地图类型
?>