<?php

	
	class Cache {
		
		static $path;
		static $enabled;
		static $exclutions;
		static $objects;
		
		private $_site;
		private $_etag;
		private $_modified;
		private $_exists;
		private $_cached;
		private $_cachename;
		
		public function __construct($site) {
			$this->_site = $site;
			
			$this->Initialize();
			                   
			$this->LoadInfo();
		}
		
		public function Initialize() {
			global $core;
			
			if(!$core->sts->Exists("SETTING_CACHE_ENABLED"))
				$core->sts->Add(new Setting("SETTING_CACHE_ENABLED", "check", 0, null, true, "System cache settings"));

			if(!$core->sts->Exists("SETTING_CACHE_EXCLUSSIONS"))
				$core->sts->Add(new Setting("SETTING_CACHE_EXCLUSSIONS", "memo", "", null, true, "System cache settings"));

			if(!$core->sts->Exists("SETTING_CACHE_PATH"))
				$core->sts->Add(new Setting("SETTING_CACHE_PATH", "text", "/_system/_cache/pages/", null, true, "System cache settings"));

			Cache::$path = $core->sts->SETTING_CACHE_PATH;
			Cache::$enabled = $core->sts->SETTING_CACHE_ENABLED == 1 ? true : false;
			Cache::$exclutions = explode(",", $core->sts->SETTING_CACHE_EXCLUSSIONS);

			if(!$core->fs->DirExists(Cache::$path)) {
				$core->fs->CreateDir(Cache::$path);
			}
			
		}
		
	
		public function LoadInfo() {
			global $core;
			$this->_etag = md5(
					is_null($this->_site->folder) ? 
						$this->_site->name
						 : 
						$this->_site->folder->name
					.
					CleanCacheFromURL()
					);
			
			$this->_modified = strtotime($this->_site->datemodified);
			$this->_cachename = Cache::$path.'/'.$this->_etag.'.cache';
			$this->_exists = $core->fs->FileExists($this->_cachename);
			
            if($this->_exists)
				$this->_cached = $core->fs->FileLastModified($this->_cachename);
			else 
				$this->_cached = 0;
			
			if(!Cache::$enabled)
				$this->_cached = 0;
		
		}
		
		function IsExcluded() {
			if(is_null($this->_site->folder))
				return array_search($this->_site->name, Cache::$exclutions) !== false;
			
			$f = $this->_site->folder;
			
			if(!is_array(Cache::$exclutions)) {
				return false;
			}
						
			foreach(Cache::$exclutions as $ff) {
				$ff = Site::Fetch($ff);
				if($f->IsChildOf($ff)) {
					return true;
				}
			}
			return false;
		}
			
		public function Render() {
			global $core;
			
			$___time = microtime(true);
			
			/*$sessionchanged = false;
			if(!is_null($core->security) && !$core->security->currentUser->isNobody)
				$sessionchanged = true;
                */
			
				
			/*$etag= '"'.$this->_etag.'"';
			$lastmodified = $this->_modified;
			if($sessionchanged)
				$lastmodified = time() + 1;

			if(!modified_since($lastmodified)) {
				header("HTTP/1.0 304 Not Modified");
				header("Content-Length: 0");
				header("ETag: {$etag}");
				return;
			}

			$body =  $this->Process();
			header("Last-Modified: ".gmdate("D, d M Y H:i:s", $lastmodified)." GMT");
			header("Expires: ".gmdate("D, d M Y H:i:s", $lastmodified + 86400)." GMT");
			header("Cache-Control: post-check=0, pre-check=0, must-revalidate, public");
			header("Content-type: text/html; charset=utf-8");
			header("Content-Length: ".strlen($body) + 3);
			header("ETag: {$etag}");
			header("Pragma: !invalid");*/
			
			$body =  $this->Process();
			//header("Pragma: no-cache");
			
			echo $body;
			//echo "<!--".(int)((microtime(true) - $___time)*1000)."-->";
		}
			
		public function Process() {
			global $core;

			if(!Cache::$enabled) {
				return $this->_site->Render();
			}

			if($this->IsExcluded())
				return $this->_site->Render();

			$isGet = isset($_GET['recache']);
			if($this->_cached < $this->_modified || $isGet) {
				// create cache and return
				$body = $this->_site->Render();
				$core->fs->DeleteFile($this->_cachename);
				$core->fs->WriteFile($this->_cachename, $body);
				return $body;
			}
			else {
				// read cache and return
				return $core->fs->ReadFile($this->_cachename);
			}
		}
		
		
	}
	

?>