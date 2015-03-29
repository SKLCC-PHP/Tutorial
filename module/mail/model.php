<?php
/**
 * The model file of mail module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2013 青岛易软天创网络科技有限公司 (QingDao Nature Easy Soft Network Technology Co,LTD www.cnezsoft.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     mail
 * @version     $Id: model.php 4750 2013-05-05 00:22:53Z chencongzhi520@gmail.com $
 * @link        http://www.zentao.net
 */
?>
<?php
class mailModel extends model
{
	public static $instance;
	public $mta;
	public $mtaType;
	public $errors = array();

	public function __construct()
	{
		parent::__construct();
		$this->app->loadClass('phpmailer', $static = true);
		$this->setMTA();
	}

	/**
	 * Auto detect email config.
	 * 
	 * @param  string    $email 
	 * @access public
	 * @return object
	 */
	public function autoDetect($email)
	{
		/* Split the email to username and domain. */
		list($username, $domain) = explode('@', $email);
		$domain = strtolower($domain);

		/*
		 * 1. try to find config from the providers. 
		 * 2. try to find the mx record to get the domain and then search it in providers.
		 * 3. try smtp.$domain's 25 and 465 port, if can connect, use smtp.$domain.
		 */
		$config = $this->getConfigFromProvider($domain, $username);
		if(!$config) $config = $this->getConfigByMXRR($domain, $username);
		if(!$config) $config = $this->getConfigByDetectingSMTP($domain, $username, 25);
		if(!$config) $config = $this->getConfigByDetectingSMTP($domain, $username, 465);

		/* Set default values. */
		$config->mta      = 'smtp';
		$config->fromName = 'zentao';
		$config->password = '';
		$config->debug    = 1;
		$config->charset  = 'utf-8';
		if(!isset($config->host)) $config->host = '';
		if(!isset($config->auth)) $config->auth = 1;
		if(!isset($config->port)) $config->port = '25';

		return $config;
   }

	/**
	 * Try get config from providers.
	 * 
	 * @param  int    $domain 
	 * @param  int    $username 
	 * @access public
	 * @return bool|object
	 */
	public function getConfigFromProvider($domain, $username)
	{
		if(isset($this->config->mail->provider[$domain]))
		{
			$config = (object)$this->config->mail->provider[$domain];
			$config->mta      = 'smtp';
			$config->username = $username;
			$config->auth     = 1;
			if(!isset($config->port))   $config->port   = 25;
			if(!isset($config->secure)) $config->secure = '';
			return $config;
		}
		return false;
	}

	/**
	 * Get config by MXRR.
	 * 
	 * @param  string    $domain 
	 * @param  string    $username 
	 * @access public
	 * @return bool|object
	 */
	public function getConfigByMXRR($domain, $username)
	{
		/* Try to get mx record, under linux, use getmxrr() directly, windows use nslookup. */
		if(function_exists('getmxrr'))
		{
			getmxrr($domain, $smtpHosts);
		}
		elseif(strpos(PHP_OS, 'WIN') !== false)
		{
			$smtpHosts = array();
			$result    = `nslookup -q=mx {$domain} 2>nul`;
			$lines     = explode("\n", $result);
			foreach($lines as $line)
			{
				if(stripos($line, 'exchanger')) $smtpHosts[] = trim(substr($line, strrpos($line, '=') + 1));
			}
		}

		/* Cycle the smtpHosts and try to find it's config from the provider config. */
		foreach($smtpHosts as $smtpHost)
		{
			/* Get the domain name from the hosts, for example: imxbiz1.qq.com get qq.com. */
			$smtpDomain = explode('.', $smtpHost);
			array_shift($smtpDomain);
			$smtpDomain = strtolower(implode('.', $smtpDomain));
			if($config = $this->getConfigFromProvider($smtpDomain, $username))
			{
				$config->username = "$username@$domain";
				return $config;
			}
		}

		return false;
	}

	/**
	 * Try connect to smtp.$domain's 25 or 465 port and compute the config according to the connection result.
	 * 
	 * @param  string $domain
	 * @param  string $username
	 * @param  int    $port 
	 * @access public
	 * @return bool|object
	 */
	public function getConfigByDetectingSMTP($domain, $username, $port)
	{
		$host = 'smtp.' . $domain;
		ini_set('default_socket_timeout', 3);
		$connection = @fsockopen($host, $port);
		if(!$connection) return false;
		fclose($connection); 

		$config->username = $username;
		$config->host     = $host;
		$config->auth     = 1;
		$config->port     = $port;
		$config->secure   = $port == 465 ? 'ssl' : '';

		return $config;
	 }

	/**
	 * Set MTA.
	 * 
	 * @access public
	 * @return void
	 */
	public function setMTA()
	{
		if(self::$instance == null) self::$instance = new phpmailer(true);
		$this->mta = self::$instance;
		$this->mta->CharSet = $this->config->charset;
		$funcName = "set{$this->config->mail->mta}";
		if(!method_exists($this, $funcName)) $this->app->triggerError("The MTA {$this->config->mail->mta} not supported now.", __FILE__, __LINE__, $exit = true);
		$this->$funcName();
	}

	/**
	 * Set smtp.
	 * 
	 * @access public
	 * @return void
	 */
	public function setSMTP()
	{
		$this->mta->isSMTP();
		$this->mta->SMTPDebug = $this->config->mail->smtp->debug;
		$this->mta->Host      = $this->config->mail->smtp->host;
		$this->mta->SMTPAuth  = $this->config->mail->smtp->auth;
		$this->mta->Username  = $this->config->mail->smtp->username;
		$this->mta->Password  = $this->config->mail->smtp->password;
		if(isset($this->config->mail->smtp->charset)) $this->mta->CharSet = $this->config->mail->smtp->charset;
		if(isset($this->config->mail->smtp->port)) $this->mta->Port = $this->config->mail->smtp->port;
		if(isset($this->config->mail->smtp->secure) and !empty($this->config->mail->smtp->secure))$this->mta->SMTPSecure = strtolower($this->config->mail->smtp->secure);
	}

	/**
	 * PHPmail.
	 * 
	 * @access public
	 * @return void
	 */
	public function setPhpMail()
	{
		$this->mta->isMail();
	}

	/**
	 * Sendmail.
	 * 
	 * @access public
	 * @return void
	 */
	public function setSendMail()
	{
		$this->mta->isSendmail();
	}

	/**
	 * Gmail.
	 * 
	 * @access public
	 * @return void
	 */
	public function setGMail()
	{
		$this->mta->isSMTP();
		$this->mta->SMTPDebug  = $this->config->mail->gmail->debug;
		$this->mta->Host       = 'smtp.gmail.com';
		$this->mta->Port       = 465;
		$this->mta->SMTPSecure = "ssl";
		$this->mta->SMTPAuth   = true;
		$this->mta->Username   = $this->config->mail->gmail->username;
		$this->mta->Password   = $this->config->mail->gmail->password;
	}

	/**
	 * Send email
	 * 
	 * @param  array   $toList 
	 * @param  string  $subject 
	 * @param  string  $body 
	 * @param  array   $ccList 
	 * @param  bool    $includeMe 
	 * @access public
	 * @return void
	 */
	public function send($toList, $subject, $body = '', $ccList = '', $includeMe = false)
	{
		if(1) return;//@Green turn off the mail at 2015-03-25

		ob_start();
		$toList  = $toList ? explode(',', str_replace(' ', '', $toList)) : array();
		$ccList  = $ccList ? explode(',', str_replace(' ', '', $ccList)) : array();

		/* Process toList and ccList, remove current user from them. If toList is empty, use the first cc as to. */
		if($includeMe == false)
		{
			$account = isset($this->app->user->account) ? $this->app->user->account : '';

			foreach($toList as $key => $to) if(trim($to) == $account or !trim($to)) unset($toList[$key]);
			foreach($ccList as $key => $cc) if(trim($cc) == $account or !trim($cc)) unset($ccList[$key]);
		}

		/* Remove deleted users. */
		$users = $this->loadModel('user')->getPairs('nodeleted');
		foreach($toList as $key => $to) if(!isset($users[trim($to)])) unset($toList[$key]);
		foreach($ccList as $key => $cc) if(!isset($users[trim($cc)])) unset($ccList[$key]);

		if(!$toList and !$ccList) return;
		if(!$toList and $ccList) $toList = array(array_shift($ccList));
		$toList = join(',', $toList);
		$ccList = join(',', $ccList);

		/* Get realname and email of users. */
		$this->loadModel('user');
		$emails = $this->user->getRealNameAndEmails(str_replace(' ', '', $toList . ',' . $ccList));
		
		$this->clear();

		/* Replace full webPath image for mail. */
		if(strpos($body, 'src="data/upload')) $body = preg_replace('/<img (.*)src="/', '<img $1 src="http://' . $this->server->http_host . $this->config->webRoot, $body);

		try 
		{
			$this->mta->setFrom($this->config->mail->fromAddress, $this->convertCharset($this->config->mail->fromName));
			$this->setSubject($this->convertCharset($subject));
			$this->setTO($toList, $emails);
			$this->setCC($ccList, $emails);
			$this->setBody($this->convertCharset($body));
			$this->setErrorLang();
			$this->mta->send();
		}
		catch (phpmailerException $e) 
		{
			$this->errors[] = trim(strip_tags($e->errorMessage()));
		} 
		catch (Exception $e) 
		{
			$this->errors[] = trim(strip_tags($e->getMessage()));
		}

		$message = ob_get_contents();
		ob_clean();

		return $message;
	}

	/**
	 * Set to address
	 * 
	 * @param  array    $toList 
	 * @param  array    $emails 
	 * @access public
	 * @return void
	 */
	public function setTO($toList, $emails)
	{
		$toList = explode(',', str_replace(' ', '', $toList));
		foreach($toList as $account)
		{
			if(!isset($emails[$account]) or isset($emails[$account]->sended) or strpos($emails[$account]->email, '@') == false) continue;
			$this->mta->addAddress($emails[$account]->email, $this->convertCharset($emails[$account]->realname));
			$emails[$account]->sended = true;
		}
	}

	/**
	 * Set cc.
	 * 
	 * @param  array    $ccList 
	 * @param  array    $emails 
	 * @access public
	 * @return void
	 */
	public function setCC($ccList, $emails)
	{
		$ccList = explode(',', str_replace(' ', '', $ccList));
		if(!is_array($ccList)) return;
		foreach($ccList as $account)
		{
			if(!isset($emails[$account]) or isset($emails[$account]->sended) or strpos($emails[$account]->email, '@') == false) continue;
			$this->mta->addCC($emails[$account]->email, $this->convertCharset($emails[$account]->realname));
			$emails[$account]->sended = true;
		}
	}

	/**
	 * Set subject 
	 * 
	 * @param  string    $subject 
	 * @access public
	 * @return void
	 */
	public function setSubject($subject)
	{
		$this->mta->Subject = stripslashes($subject);
	}

	/**
	 * Set body.
	 * 
	 * @param  string    $body 
	 * @access public
	 * @return void
	 */
	public function setBody($body)
	{
		$this->mta->msgHtml("$body");
	}

	/**
	 * Convert charset.
	 * 
	 * @param  string    $string 
	 * @access public
	 * @return string
	 */
	public function convertCharset($string)
	{
		if($this->config->mail->smtp->charset != strtolower($this->config->charset)) return iconv($this->config->charset, $this->config->mail->smtp->charset, $string);
		return $string;
	}

	/**
	 * Set error lang. 
	 * 
	 * @access public
	 * @return void
	 */
	public function setErrorLang()
	{
		$this->mta->SetLanguage($this->app->getClientLang());
	}
   
	/**
	 * Clear.
	 * 
	 * @access public
	 * @return void
	 */
	public function clear()
	{
		$this->mta->clearAddresses();
		$this->mta->clearAttachments();
	}

	/**
	 * Check system if there is a mail at least.
	 * 
	 * @access public
	 * @return bool | object 
	 */
	public function mailExist()
	{
		return $this->dao->select('email')->from(TABLE_USER)->where('email')->ne('')->fetch();
	}

	/**
	 * Is error?
	 * 
	 * @access public
	 * @return bool
	 */
	public function isError()
	{
		return !empty($this->errors);
	}

	/**
	 * Get errors. 
	 * 
	 * @access public
	 * @return void
	 */
	public function getError()
	{
		$errors = $this->errors;
		$this->errors = array();
		return $errors;
	}


	/**
	 * @author iat
	 * @date 20140831
	 */
	public function sendVerificationCode($account)
	{
		$verification_code = $this->getVerificationCode($account);
		$subject = "验证邮件";
		$content = "亲，" . $account . "是忘记密码了吗？输入如下的验证码 <font color = red>" 
			. $verification_code . "</font>重置吧！3分钟内有效</br>" . "<b>苏州大学导师制管理平台</b>&emsp;&emsp;&emsp;&emsp;" 
			. helper::now() ;
		$this->send($account, $subject, $content,"", true);
		if($this->isError())
		{
			return false;
		}
		return true;
	}

	/**
	 * @author iat
	 * @date 20140831
	 */
	private function getVerificationCode($account)
	{
		$verification = $this->dao->select('verification_code, verification_code_time')->from(TABLE_USER)
			->where('account')->eq($account)
			->fetch();

		//if the time is less than 3min, not update verification_code and verification_code_time
		if(strtotime(helper::now()) - strtotime($verification->verification_code_time) < (3*60))
		{
			$verification_code = $verification->verification_code;
		}
		else
		{
			$verification_code = rand(100000, 999999);
			$this->dao->update(TABLE_USER)
			->set('verification_code')->eq($verification_code)
			->set('verification_code_time')->eq(helper::now())
			->where('account')->eq($account)
			->exec();
		}
		return $verification_code;
	}
}
