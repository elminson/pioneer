<?php

/**
	* class ManagementPageForm
	*
	* Description for class ManagementPageForm
	*
	* @author:
	*/
class TechPageForm extends PostBackForm {
	
	/**
		* Constructor.  
		*
		* @param 
		* @return 
		*/
	function TechPageForm($lang = null) {
		parent::__construct("tech", "main", "/admin/index.php", "get");
	}
	
	function RenderContent() {
		global $core;
		$ret = "";

		$this->Out("title", $this->lang->tech_title, OUT_AFTER);
		
		switch($this->action) {
			case "bug":
				switch($this->command) {
					case "message_ok":
					case "view":
						$this->Out("subtitle", $this->lang->tech_bugreport, OUT_AFTER);
						$ret .= $this->RenderBugReportForm();
						break;
					case "send":
					
						if($this->email == "" || $this->fullname == "") {
							$ret .= $this->SetPostVar("email", $this->email);
							$ret .= $this->SetPostVar("fullname", $this->fullname);
							$ret .= $this->SetPostVar("message", $this->message);
							$ret .= $this->ErrorMessage($this->lang->error_emailnotsupllied, $this->lang->error_message_box_title);
						}
						else if(!is_email($this->email)) {
							$ret .= $this->SetPostVar("email", $this->email);
							$ret .= $this->SetPostVar("fullname", $this->fullname);
							$ret .= $this->SetPostVar("message", $this->message);
							$ret .= $this->ErrorMessage($this->lang->error_incorrectemail, $this->lang->error_message_box_title);
						}
						else {
							$integrity = new Integrity(); 
							$versionNumber = $integrity->Calc();
						
							$mail = new mailsender();
							$mail->encoding = "utf-8";
							$mail->from = $this->email;
							$mail->to = $core->sts->DEVELOPER_EMAIL;//"spawn@e-time.ru";
							$mail->subject = "A bug report from [".$core->rq->SERVER_NAME."]";
							$mail->templ = "
<b>{$this->fullname}</b> reports a bug in <b>http://{$core->rq->SERVER_NAME}</b>.<br>
<pre>
------------------------------------------------
{$this->message}
------------------------------------------------
Core Version: {$versionNumber}
</pre>
							";
							$mail->send();
							$ret .= $this->DoPostBack("sent", "get");
						}
						break;
					case "sent":
						$ret .= $this->lang->tech_bug_report_sent;
						break;
				}
				break;
			case "support":
				break;
		}
		
		
		return $ret;
	}
	
	public function MenuVisible() {
		return true;
	}
	
	public function RenderBugReportForm() {
		$ret = "";
		$integrity = new Integrity(); 
		$versionNumber = $integrity->Calc();
	
		
$ret .= <<<reportbug
		
		<table class="content-table">
			<tr>
				<td class=field>{$this->lang->tech_full_name}:</td>
				<td class=value><input type=text name=fullname value="{$this->fullname}" class=text-box style="width:300px;"></td>
			</tr>
			<tr>
				<td class=field>{$this->lang->tech_email}:</td>
				<td class=value><input type=text name=email value="{$this->email}" class=text-box style="width:180px;"></td>
			</tr>
			<tr>
				<td class=field>{$this->lang->tech_versionnumber}:</td>
				<td class=value><input type=text name=email value="{$versionNumber}" class=text-box style="width:180px;" readonly="readonly"></td>
			</tr>
			<tr>
				<td class=field>{$this->lang->tech_message}:</td>
				<td class=value>
					<textarea name=message class=text-box style="width:500px;height:200px;">{$this->message}</textarea>
				</td>
			</tr>
		</table>	
			
reportbug;

		$this->RenderToolbar(array(
			array("send", "iconpack(contact_doctor)", $this->lang->tech_send_report, "send", "post", null, null, null)
		), TOOLBAR_IMAGEONLY);

		return $ret;
	}
	
}

?>
