##《导师制管理平台》部署说明（以ubuntu14.04为例）

###1、禁止列出文件目录

在apache的配置文件`/etc/apache2/apache2.conf`中去掉对应站点Options的Indexes，从而静止访问文件目录

###2、开启伪静态

（1）在apache的配置文件`/etc/apache2/apache2.conf`中设置站点的AllowOverride 为ALL
   
 1、2两点配置最终形式如下：

<pre>
<Directory /home/iat/workspace/PHPsite>
    Options FollowSymLinks
    AllowOverride ALL
    Require all granted
</Directory></pre>

（2）使用如下命令开启伪静态
<pre>sudo a2enmod rewrite</pre>


###3、SVN导入及更新

（1）安装SVN

    sudo apt-get install subversion

（2）checkout项目（目前地址为[http://10.10.65.153:8080/svn/oa](http://10.10.65.153:8080/svn/oa)）

    svn checkout SVN服务器项目路径

（3）update项目

    svn update

（4）修改URL路径（当SVN服务器的地址改变时使用）

    svn switch --relocate 旧的地址 新的地址

###4、修改文件权限

使用如下命令将上传文件的目录改为可写权限

    sudo chmod -R a+w 'WEBSITE/www/data/upload/'

###5、可选

####1）配置虚拟主机

（1）Apache的安装目录在`/etc/apache2`下，site-available文件夹下有default和default-ssl两个文件。其中default是HTTP虚拟主机服务的配置文件，default-ssl是HTTPS服务的配置文件。新建站点的话需要新建一个配置，如下复制一份default为oa

    sudo cp /etc/apache2/sites-available/default /etc/apache2/sites-available/oa

（2）修改监听的端口、虚拟主机的项目目录、日志的目录等等

（3）激活虚拟主机配置、重启服务器
<pre>
sudo a2ensite symfony
sudo service apache2 reload
sudo service apache2 restart</pre>

####2）定时备份数据

（1）编写脚本
<pre>
#!/bin/bash
ROOT=备份路径
DIRNAME=$ROOT`date +%Y%m%d`
if [ ! -d "$DIRNAME" ]
    then
        mkdir $DIRNAME
fi
DATE=`date +%H%M%S`
mysqldump --opt -u用户名 -p密码 数据库名 > $DIRNAME/$DATE.sql</pre>

（2）写入任务

    crontab -e

添加如下行表示每小时执行一次脚本

    * */1 * * * 脚本路径

(3)激活任务

    sudo cron restart
