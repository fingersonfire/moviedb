<?php
require_once($loc . "/lib/resize/resize.php");

class Movie {
	/**
	 * Fill this movie from an IMDb movie object.
	 * @param $imdbmovie
	 */
	public function fill($imdbmovie) {
		$this->id = isset($this->id) ? $this->id : 0;
		$this->imdbid = $this->htmldecode($imdbmovie->imdbid());
		$this->name = $this->htmldecode($imdbmovie->title());
		$akas = array();
		foreach($imdbmovie->alsoknow() as $aka) {
			$title = $this->htmldecode($aka["title"]);
			$akas[$title] = $title;
		}
		$this->aka = join("\n", $akas);
		$this->year = $this->htmldecode($imdbmovie->year());
		$this->duration = $this->htmldecode($imdbmovie->runtime());
		$this->rating = $this->htmldecode($imdbmovie->rating());
		$this->own = isset($this->own) ? $this->own : true;
		$this->seen = isset($this->seen) ? $this->seen : true;
		$this->loaned = isset($this->loaned) ? $this->loaned : false;
		$this->loanname = isset($this->loanname) ? $this->loanname : "";
		$this->loandate = isset($this->loandate) ? $this->loandate : "";
		$this->trailer = isset($this->trailer) ? $this->trailer : "";
		$this->notes = isset($this->notes) ? $this->notes : "";
		$this->taglines = $this->join("\n\n", $this->htmldecode($imdbmovie->taglines()));
		$this->plotoutline = trim(strip_tags($this->htmldecode($imdbmovie->plotoutline())));
		$this->plots = $this->join("\n\n", $this->htmldecode($imdbmovie->plot()));
		$this->languages = $this->join("\n", $this->htmldecode($imdbmovie->languages()));
		$this->subtitles = isset($this->subtitles) ? $this->subtitles : "";
		$this->audio = isset($this->audio) ? $this->audio : "";
		$this->video = isset($this->video) ? $this->video : "";
		$this->country = $this->join("\n", $this->htmldecode($imdbmovie->country()));
		$this->genres = $this->join("\n", $this->htmldecode($imdbmovie->genres()));
		$this->director = $this->join("\n", $this->htmldecode($imdbmovie->director()));
		$this->writer = $this->join("\n", $this->htmldecode($imdbmovie->writing()));
		$this->producer = $this->join("\n", $this->htmldecode($imdbmovie->producer()));
		$this->music = $this->join("\n", $this->htmldecode($imdbmovie->composer()));
		$this->cast = $this->join("\n", $this->htmldecode($imdbmovie->cast()));
	}
	
	private function htmldecode($content) {
		if(is_array($content)) {
			$tmp = array();
			foreach($content as $key=>$value) {
				$tmp[$key] = $this->htmldecode($value);
			}
			return $tmp;
		} else {
			return html_entity_decode($content, ENT_QUOTES, 'UTF-8');
		}
	}
	
	private function join($glue, $pieces, $striptags = true, $allowable_tags = "") {
		$p = array();
		foreach($pieces as $piece) {
			if(is_array($piece) && isset($piece["name"]))
				$piece = $piece["name"];
			$p[] = trim(strip_tags($piece, $allowable_tags));
		}
		return join($glue, $p);
	}
	
	public function getList($field) {
		$list = $this->{$field};
		$list = preg_split("/\r?\n/", $list);
		$tmp = array();
		foreach($list as $l) {
			if(strlen(trim($l)) > 0) {
				$tmp[] = $l;
			}
		}
		return $tmp;
	}
	
	public function getYouTubeTrailerId() {
		if(preg_match("/youtube.*?v=([^&#]+)/i", $this->trailer, $matches)) {
			return $matches[1];
		}
		return false;
	}
	
	public function photo($dir = false) {
		if(!$dir) {
			global $photopath;
			$dir = $photopath;
		}
		return $dir.$this->id.".jpg";
	}
	
	public function hasPhoto($dir = false) {
		if(!$dir) {
			global $photopath;
			$dir = $photopath;
		}
		return file_exists($dir.$this->id.".jpg");
	}
	
	public function removePhoto($dir = false) {
		if(!$dir) {
			global $photopath;
			$dir = $photopath;
		}
		if($this->hasPhoto($dir))
			unlink($dir.$this->id.".jpg");
	}
	
	public function cover($dir = false) {
		if(!$dir) {
			global $coverpath;
			$dir = $coverpath;
		}
		return $dir.$this->id.".jpg";
	}
	
	public function hasCover($dir = false) {
		if(!$dir) {
			global $coverpath;
			$dir = $coverpath;
		}
		return file_exists($dir.$this->id.".jpg");
	}
	
	public function addCover($field, $dir = false) {
		global $settings;
		if(!$dir) {
			global $coverpath;
			$dir = $coverpath;
		}
		$bestand = $dir.$this->id.".jpg";
		
		// Is it jpg or png?
		$extentie = strtolower(findExtention($_FILES[$field]["name"]));
		if($extentie != "jpg") {
			return false;
		}
								
		// Remove old file
		if(file_exists($bestand))
			unlink($bestand);
			
		// Copy
		copy($_FILES[$field]["tmp_name"], $bestand);
		
		// Thumbnail
		$thumb = new thumbnail($bestand);
		$thumb->size_width($settings["photo"]["tn_maxwidth"]);
		$thumb->jpeg_quality(100);
		$thumb->save($dir."tn_".$this->id.".jpg");
	}
	
	public function removeCover($dir = false) {
		if(!$dir) {
			global $coverpath;
			$dir = $coverpath;
		}
		if($this->hasCover($dir)) {
			unlink($dir.$this->id.".jpg");
			unlink($dir."tn_".$this->id.".jpg");
		}
	}
}

?>