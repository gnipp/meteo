<?php
class TextColumn{
	
	private $content;
	private $title;
	private $linkurl;
	private $output;
	private $textlevel=3; //Ebene für Verschachtelung von Überschriften
	
	function __construct($cols, $title, $linkurl='', $content=''){
		// direkte Ausgabe von Inhalt möglich
		$this->title = $title;
		$this->linkurl = $linkurl;
		if (!empty($linkurl)) {
			$this->title = '<a href="'.$linkurl.'">'.$title.'</a>';
		}
		$this->content = $content;
		$this->output = '<div class="col-md-'.$cols.' portfolio-item">';
	}

	public function AddImage($imgurl, $imgalt='', $imglink=''){
		$imgout = '<img class="img-responsive" src="'.$imgurl.'" alt="'.$imgalt.'"/>';
		if (!empty($imgurl)){
			$imgout = '<a href="'.$imglink.'">'.$imgout.'</a>';
		} elseif (!empty($this->linkurl)) {
			$imgout = '<a href="'.$this->linkurl.'">'.$imgout.'</a>';
		}
		$this->content .= $imgout;
	}
	
	public function AddText($content){
		$this->content .= '<p>'.$content.'</p>';
	}
	
	public function AddGauge($ggId, $ggMin, $ggMax, $ggUnit, $ggValue){
		$out = '<script>';
		$out .= '$(document).ready(function() {var b = new wg.Gauge("#'.$ggId.'",200,200,'.$ggMin.','.$ggMax.', "'.$ggUnit.'", '.$ggValue.');});';
		$out .= '</script><svg id="'.$ggId.'" style="width:201px; height:202px;"></svg>';
		$this->content .= $out;
	}

	public function AddJsonTable($jsonfile, $caption='', $titlerow=true){
		// beanntes Objekt mit zweistufigem Array für min/max Darstellung
		// erste Zeile enthält Spaltentitel
		$out = self::CreateTableHeader($jsonfile, $jsonObject, $caption);
		foreach ($jsonObject as $jsonObj => $jsonArray) { //Titelobjekt
			$this->title = $jsonObj;
			$firstline = true && $titlerow;
			foreach ($jsonArray as $jsonData){ //reihe
				if ($firstline) {$out .= '<thead>';}
				$out .= '<tr>';
				foreach ($jsonData as $jsonValue){ //spalte
					if ($jsonValue === "_blanc") {break;}
					if ($firstline) {$out .= '<th>'.$jsonValue.'</th>';}
					else {$out .= '<td>'.$jsonValue.'</td>';}
				}
				$out .= '</tr>';
				if ($firstline) {$out .= '</thead><tbody>';}
				$firstline = false;
			}
		}
		$out .= '</tbody></table>';
		$this->content .= $out;
	}

	public function AddFlatTable($jsonfile, $caption=''){
		// Objekte $key:$value ohne Hierarchie
		$out = self::CreateTableHeader($jsonfile, $jsonObject, $caption); //fehler bei Tabellenaufbau: kein </head>...
		foreach ($jsonObject as $jsonObj => $jsonValue) {
			$out .= '<tr><td>'.$jsonObj.'</td><td>'.$jsonValue.'</td></tr>';
		}
		$out .= '</table>';
		$this->content .= $out;
	}

	public function AddJsonTableRecursive($jsonfile){
		// rekursives Auslesen von JSON code.
		$out = self::CreateTableHeader($jsonfile, $jsonObject, $caption='');
		$out .= self::DumpJsonToTable($jsonObject);
		$this->content .= $out;
	}

	// private functions

	private function &CreateTableHeader(&$jsonfile, &$jsonObject, $caption=''){
		if (!file_exists($jsonfile)){
			$this->content = '<p>File "'.$jsonfile.'" not found.</p>';
			return;
		}
		$jsonObject = json_decode(file_get_contents($jsonfile));
		$out = '<table class="table table-condensed table-striped">';
		if (!empty($caption)){$out .= '<caption>'.$caption.'</caption>';}
		return $out;
	}

	private function DumpJsonToTable(&$arDest){
		$out = '<thead><tr>';
		foreach ($arDest as $strTmpT => $strValue){
			$strType = 'Type: '.gettype($strTmpT);
			$out .= '<th title="'.$strType.'">'.$strTmpT.'</th>';
		}
		$out .= '</tr></thead><tbody>';
		foreach ($strValue as $strKey => $strValueA){
			$out .= '<li>'.$strValueA.'</li>';
		}
		$out .= '</tbody></table>';
		return $out;
	}

	// nesting
	private function raiseTextlevel(){
		$this->textlevel++;
	}

	public function Append($appendant){
		$appendant->raiseTextlevel();
		$this->content .= $appendant;
	}

	// magic funktion zur Ausgabe mit print <classname>;
	public function __toString(){
		$this->output .= '<h'.$this->textlevel.'>'.$this->title.'</h'.$this->textlevel.'>';
		$this->output .= $this->content.'</div>';
		return $this->output;
	}

}
?>