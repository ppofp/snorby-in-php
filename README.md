snorby-in-php
=============

Codeigniter Application For Network Security Monitoring( deriving from snorby)

******************************************************************************

因为本人不太熟悉Ruby，为了方便进一步开发snorby，因此先将其用PHP重写(使用了PHP的轻量级MVC框架：Codeigniter)
I want to add some functions to snorby but I am not familiar with Ruby, so I rewrite snorby in PHP(using the PHP MVC framework: Codeigniter).

配置：
修改application\config\database.php下的：
$db['default']['hostname'] = '192.168.116.131';
$db['default']['username'] = 'snort';
$db['default']['password'] = 'snort';
$db['default']['database'] = 'suricata';

Please modify the follow configurations in application\config\database.php
$db['default']['hostname'] = '192.168.116.131';
$db['default']['username'] = 'snort';
$db['default']['password'] = 'snort';
$db['default']['database'] = 'suricata';


******************************************************************************
实际上我还是个web 开发菜鸟，重写工作才完成了非常小的一部分，如果您能贡献和修正代码，不胜感激。
In fact I am a newbie web developer.And I have just finished a very small part of rewriting work.I will be appreciated if you contribute to this project.

If you have any query please ask me @
lihaibo@sjtu.edu.cn
