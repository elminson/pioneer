<?php

class ErrorLogLine {
	
	public $date;
	public $client;
	public $errorType;
	public $errorMessage;
	public $errorInfo;
	
}

class AccessLogLine {
	
	public $date;
	public $client;
	public $method;
	public $path;
	public $proto;
	public $status;
	public $datalen;
	public $referer;
	public $useragent;
	
/*	
	public $remoteAddress; // Remote IP-address
	public $localAddress; // Local IP-address
	public $responseSize; // Size of response in bytes, excluding HTTP headers.
	public $responseSizeCLR; // Size of response in bytes, excluding HTTP headers. In CLF format, i.e. a '-' rather than a 0 when no bytes are sent.
	public $fooBar; // The contents of cookie Foobar in the request sent to the server.
	public $requestTimeMilliseconds; // The time taken to serve the request, in microseconds.
	public $fooBarContent; // The contents of the environment variable FOOBAR
	public $filename; // Filename
	public $remoteHost; // Remote host
	public $requestProto; // The request protocol
	public $fooBarHeaders; // The contents of Foobar: header line(s) in the request sent to the server.
	public $remoteLogName; // Remote logname (from identd, if supplied). This will return a dash unless mod_ident is present and IdentityCheck is set On.
	public $requestMethod; // The request method
	public $fooBarNodeContentAnotherModule; // The contents of note Foobar from another module.
	public $fooBarHeaderLines; // The contents of Foobar: header line(s) in the reply.
	public $serverPort; // The canonical port of the server serving the request
	public $childProcessId; // The process ID of the child that serviced the request.
	public $requestChildProcessId; // The process ID or thread id of the child that serviced the request. Valid formats are pid, tid, and hextid. hextid requires APR 1.2.0 or higher. 
	public $queryString; // The query string (prepended with a ? if a query string exists, otherwise an empty string)
	public $requestFirstLine; // First line of request
	public $status; // Status. For requests that got internally redirected, this is the status of the *original* request --- %>s for the last.
	public $requestTime; // Time the request was received (standard english format)
	public $requestFormatedTime; // The time, in the form given by format, which should be in strftime(3) format. (potentially localized)
	public $requestTimeSeconds; // The time taken to serve the request, in seconds.
	public $removeUser; // Remote user (from auth; may be bogus if return status (%s) is 401)
	public $urlRequested; // The URL path requested, not including any query string.
	public $serverName; // The canonical ServerName of the server serving the request.
	public $serverNameFormated; // The server name according to the UseCanonicalName setting.
	public $connectionStatus; // Connection status when response is completed: X = connection aborted before the response completed. 
								// + = connection may be kept alive after the response is sent. 
								// - =  connection will be closed after the response is sent. 
								//
								// (This directive was %c in late versions of Apache 1.3, but this conflicted with the historical ssl %{var}c syntax.)
								//
	public $bytesReceived; // Bytes received, including request and headers, cannot be zero. You need to enable mod_logio to use this.
	public $bytesSent; // Bytes sent, including headers, cannot be zero. You need to enable mod_logio to use this.
*/

}

class LogParser {
	
	private $logpath;
	private $type;
	
	private $format; /*pattern*/
	
	public function __construct($logpath, $type = ACCESS_LOG, $format = null) {
		$this->logpath = $logpath;
		$this->type = $type;
		$this->format = $format;
	}
	
	public function Parse($logOrderBy = null) {
		if($this->type == ACCESS_LOG) {
			return $this->_parseAccessLog($logOrderBy);
		}
		else {
			return $this->_parseErrorLog($logOrderBy);
		}
	}
	
	private function _parseAccessLog($logOrderBy = null) {
		// 83.102.130.250 - - [22/Nov/2006:14:01:12 +0300] "GET /core/extras/spaw/lib/themes/classic/img/tb_copy.gif HTTP/1.0" 200 893 
		$pattern = is_null($this->format) ? "/^(.*?) .*? \[(.*?)\] \"([^\s]*) ([^\s]*) ([^\"]*)\" ([^\s]*) (.*?) (\".*\"?) (\".*\"?)$/i" : $this->format;
		
		$log_lines = file($this->logpath);
		if(is_null($logOrderBy))
			$log = new ArrayList();
		else
			$log = new Collection();
		
		if(count($log_lines) > 0) {
			foreach($log_lines as $line) {
				  
				// parse line
				if(preg_match($pattern, $line, $matches) > 0) {
					$access = new AccessLogLine();
					$access->client = @$matches[1];
					$access->date = strtotime(@$matches[2]);
					$access->method = @$matches[3];
					$access->path = @$matches[4];
					$access->proto = @$matches[5];
					$access->status= @$matches[6];
					$access->datalen = @$matches[7];
					if(count($matches) > 7) {
						$access->referer = trim(@$matches[8], "\"");	
						$access->useragent = @$matches[9];	
						$access->useragent = substr($access->useragent, 1, strlen($access->useragent)-3);
					}
					
					if(strpos($access->path, "/admin/") === false && strpos($access->path, "/core/") === false) {
						if(is_null($logOrderBy))
							$log->Add($access);
						else {
							$k = $access->$logOrderBy;
							$ordered = $log->$k;
							if(is_null($ordered))
								$ordered = new ArrayList();
							$ordered->Add($access);
							$log->Add($access->$logOrderBy, $ordered);
						}
					}
					else {
						unset($access);
					}
				}		
			}
		}		
		return $log;	
	}
	

	private function _parseErrorLog($logOrderBy = null) {
		// [Mon Nov 20 12:18:27 2006] [error] [client 83.102.130.250] File does not exist: D:/Sites2.3/www.3st.ru/www/styles, referer: http://3st.grcom.ru/
		$pattern = is_null($this->format) ? "/\[(.*?)\] \[(.*?)\] \[client (.*?)\] ([^:]*?): (.*?)$/i" : $this->format;
		$log_lines = file($this->logpath);
		if(is_null($logOrderBy))
			$log = new ArrayList();
		else
			$log = new Collection();
		
		if(count($log_lines) > 0) {
			foreach($log_lines as $line) {
				  
				// parse line
				if(preg_match($pattern, $line, $matches) > 0) {
					$error = new ErrorLogLine();
					$error->date = strtotime(@$matches[1]);
					$error->errorType = @$matches[2];
					$error->client = @$matches[3];
					$error->errorMessage = @$matches[4];
					$error->errorInfo = @$matches[5];
					if(is_null($logOrderBy))
						$log->Add($error);
					else {
						$k = $error->$logOrderBy;
						$ordered = $log->$k;
						if(is_null($ordered))
							$ordered = new ArrayList();
						$ordered->Add($error);
						$log->Add($error->$logOrderBy, $ordered);
					}
				}		
			}
		}
		return $log;		
	}
	
	
}

?>
