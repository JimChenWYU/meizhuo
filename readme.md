## 袂卓工作室招新报名系统

### 功能介绍
+ 报名系统
	- 面试报名
+ 后台管理
	- 管理已报名同学
	- 管理来面试同学
	- 管理登录面试系统面试的面试官
+ 签到前台
	- 已报名面试同学排队
+ 面试功能
	- 面试官登录获取面试者信息

### 使用说明
假设你在开发环境下，首先在你的工作区间执行命令
```git
$ git clone git@github.com:JimChenWYU/meizhuo.git
```
切换到开发分支
```git
$ git checkout dev
```
安装后端依赖
```git
$ composer install
```
安装前端依赖
```git
$ npm install
```

根据自己环境配置.env文件
```git
$ cp .env.example .env
```

根据自己环境配置config.json文件,
**注意: `dev`为开发环境路径，`prod`为生产环境路径， `request_url`不要改！**
```git
$ cd resources/assets/js/config/
$ cp config.example.json config.json
```
配置webSocket服务器,
**注意：`httpServer`为监听webSocket服务器地址和端口，`redis`为你的redis地址和端口**
```git
$ cp webSocketServer/env.example.json webSocketServer/env.json
```
配置之后编译前端资源(开发环境版本)
```git
$ npm run dev
```
打开webSocket
```git
$ npm run start
```
至此打开你的服务器，建议使用 [homestead](https://github.com/laravel/homestead) 虚拟机，查看[路由文件](app/Http/routes.php)即可知道访问路径，生产环境下大同小异，注意权限分配即可。

如有疑问可以邮件联系或提issues：[18219111672@163.com](mailto://18219111672@163.com)

### BUG修复
~~代号x0000001: 面试官搜索之后开始面试，面试者状态没有改变~~

~~代号x0000002: 面试官搜索不提示前台，通知下一位面试者时发出多条通知~~

[MIT license](http://opensource.org/licenses/MIT)
