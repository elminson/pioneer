<?

class GeneralPageForm extends PostBackForm {
	public $welcomemessage;

	public function GeneralPageForm($lang = null) {
		global $core;
		parent::__construct("general", "main", "/admin/index.php", "get");
		$this->welcomemessage = $core->sts->SETTING_WELCOME_MESSAGE;
	}

	public function RenderContent() {
		return $this->RenderMain();
	}

	public function MenuVisible() {
		return false;
	}

	function UseExternalInterface() {
		return false;
	}
	

	function RenderMain() {
		global $core;
		$ret = "";
		
		switch($this->command) {
			case "view":
				if($core->security->currentUser->isNobody())
					$ret .= $this->DoPostBack("loginform", "post");
				else
					$ret .= $this->DoPostBack("view", "get", "development", "structure");
				break;
			case "loginerror":
			case "loginform":
				$ret .= $this->RenderLoginForm();
				break;
			case "login":
				if(!$core->security->Login($this->users_name, $this->users_password)) {
					$ret .= $this->SetPostVar("msg", "<span class=warning>Incorrect user name or password</span>");
					$ret .= $this->DoPostBack("loginerror", "post");
				}
				else {
					if(!($core->security->currentUser->profile->admin instanceof Profiler)) {
						$core->security->currentUser->profile->admin = new Profiler($core->security->currentUser);
						$core->security->currentUser->Save();
					}
					
					$ret .= $this->DoPostBack("view", "get", "development", "structure");
				}
				break;
			case "logout":
				$core->security->logout();
				$ret .= $this->DoPostBack("view", "post", "general", "main");
				break;
		}
		return $ret;
	}


	function RenderLoginForm() {
		$ret = "";
		//{$this->welcomemessage}
        
        $ret .= '
            <table cellpadding="0" cellspacing="0" border="0" style="width: 100%; height: 100%; background-color: #000;"><tr>
                <td style="background-image: url(images/v5/first-page.jpg); background-repeat: no-repeat; background-position: center center; ">
                
                <table cellpadding="0" cellspacing="0" align="center" width="557"><tr><td style="padding-top: 80px;">
                <table border="0" align="right" cellpadding="0" cellspacing="0" >
                    <tr><td>
                        &nbsp;
                    </td><td align="right" style="padding: 5px; padding-right: 0px;">
                        <span style="color: #fff; font-size: 22px; font-weight: bold; font-family: Arial">Авторизация</span>
                    </td></tr>
                    <tr><td colspan="2" align="right" style="padding: 5px; padding-right: 0px; color: #ff0">&nbsp;'.$this->msg.'</td></tr>
                    <tr><td align="right" style="color: #e1e1e1; font-size: 14px; font-family: Arial; padding: 10px;">
                    '.$this->lang->general_user_name.'
                    </td><td align="right">
                        <input name="users_name" type="text" id="idUserId" style="font-size: 14px;" value="'.$this->users_name.'">
                    </td></tr>
                    <tr><td align="right" style="color: #e1e1e1; font-size: 14px; font-family: Arial; padding: 10px;">
                        '.$this->lang->general_password.'
                    </td><td align="right">
                        <input name="users_password" type="password" style="font-size: 14px;" value="'.$this->users_password.'">
                    </td></tr>
                    <tr><td align="right">
                        &nbsp;
                    </td><td align="right" style="padding: 10px; padding-right: 0px;">
                        <input type="submit" style="padding: 0px 20px 0px 20px; font-size: 14px;" name="login" id="login" value="'.$this->lang->general_login.'" onclick="return PostBack(\'login\', \'post\');">
                    </td>
                </tr></table>      
                </td></tr><tr><td align="right">
                Для входа в систему воспользуйтесь своим Именем пользователя и Паролем.
                </td></tr><tr><td align="right" style="padding-top: 35px; color: #fff">
                © 2007. E-time. All rights Reserved.
                </td></tr></table>              
                
                
                </td>
            </tr></table>
            
        ';

		return $ret;
	}

	function RenderTitle() {
		return $this->lang->general_title;
	}

}
?>
